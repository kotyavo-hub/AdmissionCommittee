<?php declare(strict_types=1);

namespace AC\Service\Http;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Response implements ResponseInterface
{
    /**
     * @Inject
     * @var Environment
     */
    private Environment $twig;

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

    public function setParamFromSessionVar($key, $param)
    {
        session_start();
        $_SESSION[$key] = $param;
    }

    public function redirect(string $url)
    {
        header('Location: '.'http://localhost/');
    }

    public function destroySession(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();
    }

    private function getMenuData()
    {
        return [
            [
                'href' => '/registration/',
                'name' => 'Регистрация',
            ],
            [
                'href' => '/login/',
                'name' => 'Вход',
            ],
            [
                'href' => '/exit/',
                'name' => 'Выход',
            ],
        ];
    }

    /**
     * @param string $template
     * @param $data
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function display(string $template, array $data = [])
    {
        $data['menu'] = $this->getMenuData();
        $this->twig->display($template, $data);
    }
}