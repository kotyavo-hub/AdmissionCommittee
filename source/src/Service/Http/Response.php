<?php declare(strict_types=1);

namespace AC\Service\Http;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Menu\Enum\MenuConfigFilesEnum;
use AC\Service\Http\Enum\HttpCodeEnum;
use AC\Service\Menu\MenuGenerator;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Сервис для отправки данных пользователю
 *
 * Class Response
 * @package AC\Service\Http
 */
class Response implements ResponseInterface
{
    /**
     * @Inject
     * @var Environment
     */
    private Environment $twig;

    /**
     * @Inject
     * @var Request
     */
    private Request $request;

    /**
     * @Inject
     * @var MenuGenerator
     */
    private MenuGenerator $menuGenerator;

    /**
     * @param string[] $resp
     */
    public function toJson(array $resp)
    {
        echo json_encode($resp);
    }

    public function renderString(string $value)
    {
        echo $value;
    }

    /**
     * @param string $param
     */
    public function setHeader(string $param): void
    {
        header($param);
    }

    /**
     * @param $key
     * @param $param
     * @return void
     */
    public function setParamFromSessionVar($key, $param)
    {
        session_start();
        $_SESSION[$key] = $param;
    }

    /**
     * @param string $url
     * @return mixed|void
     */
    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    public function destroySession(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();
    }

    /**
     * @return array
     * @throws ConfigFileNotFoundException
     */
    protected function getMenuData(): array
    {
        $menuData = [];

        $menuData['header'] = $this->menuGenerator->generateMenu(
            MenuConfigFilesEnum::HEADER()
        );

        return $menuData;
    }

    /**
     * @param string $template
     * @param $data
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ConfigFileNotFoundException
     */
    public function display(string $template, array $data = [])
    {
        $data['menu'] = $this->getMenuData();
        $this->twig->display($template, $data);
    }

    /**
     * @param HttpCodeEnum $code
     */
    public function setCode(HttpCodeEnum $code): void
    {
        http_response_code($code->getValue());
    }
}