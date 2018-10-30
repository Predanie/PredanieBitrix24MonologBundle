<?php

namespace Predanie\Bitrix24Bundle\Handler;

use Predanie\Bitrix24Bundle\Manager\Bitrix24Manager;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class MonologHandler extends AbstractProcessingHandler
{
	/**
	 * @var Bitrix24Manager
	 */
	private $bitrix24Manager;

	/**
	 * @var RequestStack
	 */
	protected $request;

	protected $server;
	protected $post;
	protected $get;
	protected $room;
	protected $name;
	protected $httpHost;
	protected $httpScheme;

	/**
	 * @param RequestStack $request
	 * @param Bitrix24Manager $bitrix24Manager
	 */
	public function __construct(RequestStack $request, Bitrix24Manager $bitrix24Manager)
	{
		$this->request = $request->getCurrentRequest() ? $request->getCurrentRequest() : Request::createFromGlobals();
		$this->bitrix24Manager = $bitrix24Manager;
		$this->server = $this->request->server;
		$this->post = $this->request->request;
		$this->get = $this->request->query;
	}

	/**
	 * Send message to HipChat room
	 *
	 * @param  array
	 * @return bool
	 */
	protected function write(array $record)
	{
		if ($record['level'] < Logger::ERROR) {
			return false;
		}

		if (isset($record['context']['exception'])
			&&    ($record['context']['exception'] instanceof NotFoundHttpException
				|| $record['context']['exception'] instanceof AccessDeniedHttpException
				|| $record['context']['exception'] instanceof ResourceNotFoundException)
		) {
			return false;
		}

		$msg = '';
		if ($this->server->get('HTTP_HOST') && $this->server->get('REQUEST_URI')) {
			$scheme = $this->httpScheme ? $this->httpScheme : $this->server->get('REQUEST_SCHEME');

			if (is_null($scheme)) {
				$https = $this->server->get('HTTPS');
				$scheme = (empty($https) || 'off' === $https) ? 'http' : 'https';
			}

			$host = $this->httpHost ? $this->httpHost : $this->server->get('HTTP_HOST');

			if (false !== idn_to_utf8($host)) {
				$host = idn_to_utf8($host);
			}

			$msg = sprintf('Request url: %s:// %s%s[BR]', $scheme, $host, $this->server->get('REQUEST_URI'));
		}

		if ($this->post->count() > 0 || $this->get->count() > 0) {
			$data = array_merge($this->post->all(), $this->get->all());
			$msg .= "Request data: ".json_encode($data)."[BR]";
		}

		if (isset($record['message'])) {
			$this->bitrix24Manager->imMessageAdd($msg . $record['message']);
			return true;
		}

		return false;
	}
}
