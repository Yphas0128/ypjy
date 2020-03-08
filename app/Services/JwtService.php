<?php


    namespace App\Services;


    use Tymon\JWTAuth\Facades\JWTAuth;

    class JwtService
    {

        public function __construct(){
            \Config::set("auth.defaults.guard","apijwt");
        }



        public function set_toke($data){
            if(!$token = JWTAuth::attempt($data)){
                return [];
            }
            return $this->respond_with_token($token);
        }

        public function my(){
            return JWTAuth::parseToken()->touser();
        }

        /**
         * @name  刷新
         */
        public function refresh()
        {
            return $this->respond_with_token(JWTAuth::parseToken()->refresh());
        }

        /**
         * @name 组合token数据
         */
        protected function respond_with_token($token)
        {
            return [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ];
        }


    }