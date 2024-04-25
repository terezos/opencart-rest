<?php
class ControllerExtensionApiV1Orders extends Controller {

    private ?int $orderId;

    private string $message;

    private int $statusCode = 200;

    public function __construct($registry)
    {
        parent::__construct($registry);

        $reqParameters = explode('/', $this->request->get['route']);
        $this->orderId = (isset($reqParameters[4]) && $reqParameters[4] != '') ? (int)$reqParameters[4] : null;
        if (!$this->validate()) {
            header('Content-type: application/json');
            http_response_code($this->statusCode);
            die(json_encode(['error' => $this->message]));
        }
        $this->getOrder();
    }

    public function getOrder()
    {
        header('Content-type: application/json');
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrderApi($this->orderId);

        if ($order_info) {
            http_response_code($this->statusCode);
            die(json_encode(['order' => $order_info]));
        } else {
            http_response_code($this->statusCode);
            die(json_encode(['error' => 'Order not found']));
        }
    }

    private function validateBasicAuth(): bool
    {
        if ((!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) && !isset($_SERVER['HTTP_AUTHORIZATION']))
            return false;

        if (!isset($_SERVER['HTTP_AUTHORIZATION']))
            return false;

        $basicAuth = explode(' ', trim($_SERVER['HTTP_AUTHORIZATION']))[1];
        $systemAuth = base64_encode($this->config->get('feed_api_username').':'.$this->config->get('feed_api_password'));

        return $basicAuth === $systemAuth;
    }

    private function validate(): bool
    {
        if (!$this->config->get('feed_api_status')){
            $this->message = 'Not Found';
            $this->statusCode = 404;
            return false;
        }

        if (!$this->validateBasicAuth()) {
            $this->message = 'Unauthorized access';
            $this->statusCode = 401;
            return false;
        }

        return true;
    }
}
