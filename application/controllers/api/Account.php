<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Account extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }

    protected function _prepare_ip($ip_address)
    {
        return $ip_address;
    }

    public function register_post()
    {
        $email = $this->post('email', TRUE);
        $nama = $this->post('nama', TRUE);
        $token = base64_encode(random_bytes(30));
        $type = "verify";
        $data = [
            'nama' => $nama,
            'username' => $this->post('username', TRUE),
            'email' => $email,
            'phone' => $this->post('phone', TRUE),
            'password' => md5($this->post('password', TRUE)),
            'ip_address' => $this->_prepare_ip($this->input->ip_address()),
            'user_created' => time(),
            'activation_code' => $token,
            'active' => 0
        ];

        $this->_sendEmail($email, $nama, $type, $token);

        if ($this->user->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new user has been created, please activate teh email',
                'data' => $data
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], 400);
        }
    }

    private function _sendEmail($emailTo, $nama, $type, $token)
    {
        $verifyLink = base_url() . 'account/verify?email=' . $emailTo . '&token=' . urlencode($token);
        $forgotLink = base_url() . 'account/resetpassword?email=' . $emailTo . '&token=' . $token;
        // $messageVerify = '<!DOCTYPE html><html><head></head><body style="background-color: #88BDBF;margin: 0px"><table border="0" width="50%" style="margin:auto;padding:30px;background-color: #F3F3F3;border:1px solid #FF7A5A;"><tr><td><table border="0" width="100%"><tr><td><h1>FPPW</h1></td><td><p style="text-align: right;"><a href="https://cektrend.com/" target="_blank"style="text-decoration: none;">Contact Developer</a></p></td></tr></table></td></tr><tr><td><table border="0" cellpadding="0" cellspacing="0"style="text-align:center;width:100%;background-color: #fff;"><tr><td style="background-color:#FF7A5A;height:100px;font-size:50px;color:#fff;">&#9993;</td></tr><tr><td><h1 style="padding-top:25px;">Email Verifikasi</h1></td></tr><tr><td><p style="padding:0px 100px;">Hi ' . $nama . ', Silahkan lakukan verifikasi email dengan cara klik tombol dibawah, lalu setelah selesai verifikasi silahkan login kembali ke aplikasi..</p></td></tr><tr><td><a href="' . $verifyLink . '" target="_blank"style="margin:10px 0px 30px 0px;border-radius:4px;display: inline-block;padding:10px 20px;border: 0;text-decoration: none;color:#fff;background-color:#FF7A5A;cursor:pointer;">Verifikasi Email</a></td></tr></table></td></tr><tr><td><table border="0" width="100%" style="border-radius: 5px;text-align: center;"><tr><td><h3 style="margin-top:10px;">Hormat Kami</h3></td></tr><tr><td><div style="margin-top:20px;"><a href="https://instagram.com/forumwarudoyong"target="_blank" style="text-decoration: none;"><span class="twit"style="padding:10px 9px;color:#fff;border-radius:50%;"><img src="https://ci6.googleusercontent.com/proxy/LnF3L9D4O2ZXfjS1325tSsjGunP0M39ueoULrIk4ad7GcB8BB7H1nJz9NPoOZXwPM5mq6eBAupTv98tkexf-0QPeiAxOqOnZOugro0MDIyjp8orZTGC1w_pBiv4=s0-d-e1-ft#https://www.exabytes.co.id/newsletter/images/icons/color-instagram-40.png" height="38" width="38"></span></a><a href="https://www.facebook.com/reksawiguna.sindangherang"target="_blank" style="text-decoration: none;"><span class="fb"style="padding:10px 9px;color:#fff;border-radius:50%;"><img src="https://ci6.googleusercontent.com/proxy/7fWp8xPSTar1PwN2HalVAS1Z20q2qKfmbrem1g7iaPLaKxkV-WYTUDzIzwoEDjoEy99r6Hpgt-zfE-7dGJFpBYvFjAwx8lBJ-GWdFLxg6zIUd3_mcGW0u0N9sg=s0-d-e1-ft#https://www.exabytes.co.id/newsletter/images/icons/color-facebook-40.png" height="38" width="38"></span></a></div></td></tr><tr><td><div style="margin-top: 20px;"><span style="font-size:12px;">Forum Pemuda PemudiWarudoyong</span><br><span style="font-size:12px;">Copyright © 2020 <a href="https://instagram.com/saipulmuiz" target="_blank"title="Cektrend Developer"> Cektrend Developer</a></span></div></td></tr></table></td></tr></table></body></html>';
        // $messageForgot = '<!DOCTYPE html><html><head></head><body style="background-color: #88BDBF;margin: 0px"><table border="0" width="50%" style="margin:auto;padding:30px;background-color: #F3F3F3;border:1px solid #FF7A5A;"><tr><td><table border="0" width="100%"><tr><td><h1>FPPW</h1></td><td><p style="text-align: right;"><a href="https://cektrend.com/" target="_blank"style="text-decoration: none;">Contact Developer</a></p></td></tr></table></td></tr><tr><td><table border="0" cellpadding="0" cellspacing="0"style="text-align:center;width:100%;background-color: #fff;"><tr><td style="background-color:#FF7A5A;height:100px;font-size:50px;color:#fff;">&#9993;</td></tr><tr><td><h1 style="padding-top:25px;">Reset Password</h1></td></tr><tr><td><p style="padding:0px 100px;">Hi ' . $nama . ', Silahkan reset password dengan cara klik tombol dibawah, lalu akan diarahkan ke menu ganti password..</p></td></tr><tr><td><a href="' . $forgotLink . '" target="_blank"style="margin:10px 0px 30px 0px;border-radius:4px;display: inline-block;padding:10px 20px;border: 0;text-decoration: none;color:#fff;background-color:#FF7A5A;cursor:pointer;">Reset Password</a></td></tr></table></td></tr><tr><td><table border="0" width="100%" style="border-radius: 5px;text-align: center;"><tr><td><h3 style="margin-top:10px;">Hormat Kami</h3></td></tr><tr><td><div style="margin-top:20px;"><a href="https://instagram.com/forumwarudoyong"target="_blank" style="text-decoration: none;"><span class="twit"style="padding:10px 9px;color:#fff;border-radius:50%;"><img src="https://ci6.googleusercontent.com/proxy/LnF3L9D4O2ZXfjS1325tSsjGunP0M39ueoULrIk4ad7GcB8BB7H1nJz9NPoOZXwPM5mq6eBAupTv98tkexf-0QPeiAxOqOnZOugro0MDIyjp8orZTGC1w_pBiv4=s0-d-e1-ft#https://www.exabytes.co.id/newsletter/images/icons/color-instagram-40.png" height="38" width="38"></span></a><a href="https://www.facebook.com/reksawiguna.sindangherang"target="_blank" style="text-decoration: none;"><span class="fb"style="padding:10px 9px;color:#fff;border-radius:50%;"><img src="https://ci6.googleusercontent.com/proxy/7fWp8xPSTar1PwN2HalVAS1Z20q2qKfmbrem1g7iaPLaKxkV-WYTUDzIzwoEDjoEy99r6Hpgt-zfE-7dGJFpBYvFjAwx8lBJ-GWdFLxg6zIUd3_mcGW0u0N9sg=s0-d-e1-ft#https://www.exabytes.co.id/newsletter/images/icons/color-facebook-40.png" height="38" width="38"></span></a></div></td></tr><tr><td><div style="margin-top: 20px;"><span style="font-size:12px;">Forum Pemuda PemudiWarudoyong</span><br><span style="font-size:12px;">Copyright © 2020 <a href="https://instagram.com/saipulmuiz" target="_blank"title="Cektrend Developer"> Cektrend Developer</a></span></div></td></tr></table></td></tr></table></body></html>';
        // $this->load->library('email');
        // $this->email->set_newline("\r\n");
        // $config = [
        //     'protocol' => 'smtp',
        //     'smtp_host' => 'mail.cektrend.com',
        //     'smtp_user' => 'fppw@cektrend.com',
        //     'smtp_pass' => 'saipul123258',
        //     'smtp_port' => 587,
        //     'mailtype' => 'html',
        //     'charset' => 'utf-8',
        //     'newline' => "\r\n"
        // ];

        // $this->email->initialize($config);

        // $this->email->from('fppw@cektrend.com', 'Forum Pemuda Pemudi Warudoyong');
        // $this->email->to($emailTo);

        if ($type == 'verify') {
            // $this->email->subject('Akun Verfikasi FPPW');
            // $this->email->message($messageVerify);
            echo $verifyLink;
        } elseif ($type = 'forgot') {
            // $this->email->subject('Konfirmasi Lupa Password FPPW');
            // $this->email->message($messageForgot);
            echo $forgotLink;
        }

        // if ($this->email->send()) {
        //     return true;
        // } else {
        //     echo $this->email->print_debugger();
        //     die;
        // }
    }

    public function login_post()
    {
        $data = [
            'username' => trim($this->input->post('username', TRUE)),
            'password' => md5(trim($this->input->post('password', TRUE)))
        ];

        $check = $this->db->get_where('tbl_user', array('username' => $this->post('username', TRUE)));
        $row = $this->db->get_where('tbl_user', $data)->row();
        $count = empty($row) ? 0 : 1;

        if ($check->num_rows() >= 1) {
            if ($count >= 1) {
                $result = [
                    'logged_in' => true,
                    'id' => $row->id,
                    'username' => $row->username,
                    'nama' => $row->nama,
                ];

                $this->response([
                    'status' => true,
                    'message' => 'login successfull',
                    'result' => $result
                ], 200);
            } else {
                $this->response([
                    'status' => true,
                    'message' => 'login failed, check your password again!'
                ], 401);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'username not found!'
            ], 401);
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('tbl_user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('tbl_user', ['activation_code' => $token])->row_array();

            if ($user_token) {
                $this->db->set('active', 1);
                $this->db->where('email', $email);
                $this->db->update('tbl_user');

                $this->db->delete('tbl_token', ['token' => $token]);

                echo $email . ' Sudah aktif, Silahkan login ke aplikasi';
            } else {
                echo 'Aktivasi gagal!, Token salah atau kadaluarsa!';
            }
        } else {
            echo 'Aktivasi gagal!, Email tidak terdaftar!';
        }
    }

    public function forgotPassword_post()
    {

        $email = trim($this->input->post('email', TRUE));
        $token =  base64_encode(random_bytes(30));
        $type = "forgot";

        $check = $this->db->get_where('tbl_user', ['email' => $email, 'active' => 1]);

        if ($check->num_rows() >= 1) {
            if ($this->user->forgotPassword($email, $token) > 0) {
                $this->_sendEmail($email, "", $type, $token);
                $this->response([
                    'status' => true,
                    'message' => 'Please check your email for next step!'
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Failed to execute program!, Contact Admin!'
                ], 400);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'email not registered or activated!'
            ], 401);
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('tbl_user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('tbl_user', ['forgotten_password_code' => $token])->row_array();

            if ($user_token) {
                $this->db->set('forgotten_password_time', time());
                $this->db->where('email', $email);
                $this->db->update('tbl_user');

                echo $email . ' Silahkan Ganti Password!';
            } else {
                echo 'Aktivasi gagal!, Token salah atau kadaluarsa!';
            }
        } else {
            echo 'Aktivasi gagal!, Email tidak terdaftar!';
        }
    }
}
