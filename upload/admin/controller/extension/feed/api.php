<?php

class ControllerExtensionFeedApi extends Controller
{
    public function index()
    {
        $this->load->language('extension/feed/api');
        $this->load->model('setting/setting');
        $this->document->setTitle($this->language->get('heading_title'));

        $data = [
            'action' => $this->url->link('extension/feed/api', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'cancel' => $this->url->link('extension/feed', 'user_token=' . $this->session->data['user_token'], 'SSL')
        ];

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_setting_setting->editSetting('feed_api', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=feed', true));
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => false
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_feed'),
            'href' => $this->url->link('extension/feed', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => ' :: '
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/feed/api', 'user_user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => ' :: '
        ];

        if (isset($this->request->post['feed_api_status'])) {
            $data['feed_api_status'] = $this->request->post['feed_api_status'];
        } else {
            $data['feed_api_status'] = $this->config->get('feed_api_status');
        }

        if (isset($this->request->post['feed_api_username'])) {
            $data['feed_api_username'] = $this->request->post['feed_api_username'];
        } else {
            $data['feed_api_username'] = $this->config->get('feed_api_username');
        }

        if (isset($this->request->post['feed_api_password'])) {
            $data['feed_api_password'] = $this->request->post['feed_api_password'];
        } else {
            $data['feed_api_password'] = $this->config->get('feed_api_password');
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');;
        $this->response->setOutput($this->load->view('extension/feed/api', $data));
    }
}
