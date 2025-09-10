<?php

namespace App\Controllers;

use App\Models\User_Model;

class Auth extends BaseController
{
    public function login()
    {
        $email     = $this->request->getPost( "email" );
        $password  = $this->request->getPost( "password" );
        $user_type = $this->request->getPost( "user_type" ); // Get user_type from request

        $User_Model = new User_Model();

        // Query using both email and user_type
        $user = $User_Model
            ->where( "email", $email )
            ->where( "user_type", $user_type )
            ->first();

        $success = false;

        if ( $user && password_verify( $password, $user[ "password" ] ) ) {
            $success = true;

            session()->setFlashdata( [ 
                "type"    => "success",
                "message" => "Welcome back, " . $user[ "name" ] . "!",
            ] );

            session()->set( "user", [ 
                "users_id"   => $user[ "users_id" ],
                "name"       => $user[ "name" ],
                "contact_no" => $user[ "contact_no" ],
                "email"      => $user[ "email" ],
                "image"      => $user[ "image" ],
                "user_type"  => $user[ "user_type" ],
            ] );
        }

        return $this->response->setJSON( [ 
            "success"   => $success,
            "user_type" => $success ? $user[ "user_type" ] : null,
        ] );
    }

    public function signup()
    {
        $name     = ucwords( strtolower( trim( $this->request->getPost( "name" ) ) ) );
        $email    = $this->request->getPost( "email" );
        $contact  = $this->request->getPost( "contact" );
        $password = $this->request->getPost( "password" );

        $User_Model = new User_Model();

        $user = $User_Model->where( "contact_no", $contact )->first();

        $success    = false;
        $error_type = null;

        if ( $user ) {
            $error_type = "contact_exists";
        } else {

            $user = $User_Model->where( "email", $email )->first();

            if ( $user ) {
                $error_type = "email_exists";
            } else {
                $data = [ 
                    "uuid"       => generate_uuid(),
                    "name"       => $name,
                    "contact_no" => $contact,
                    "email"      => $email,
                    "password"   => password_hash( $password, PASSWORD_BCRYPT ),
                    "image"      => "default-user-image.webp",
                    "user_type"  => "user",
                    "created_at" => date( "Y-m-d H:i:s" ),
                    "updated_at" => date( "Y-m-d H:i:s" ),
                ];

                if ( $User_Model->insert( $data ) ) {
                    $success = true;

                    session()->setFlashdata( [ 
                        "type"    => "success",
                        "message" => "Account created successfully! You can now log in.",
                    ] );

                } else {
                    $success    = false;
                    $error_type = "db_error";
                }
            }
        }

        return $this->response->setJSON( [ 
            "success"    => $success,
            "error_type" => $error_type
        ] );
    }

    public function updateProfile()
    {
        $id       = $this->request->getPost( 'id' );
        $name     = ucwords( strtolower( trim( $this->request->getPost( "name" ) ) ) );
        $contact  = $this->request->getPost( 'contact' );
        $email    = $this->request->getPost( 'email' );
        $password = $this->request->getPost( 'password' );

        $User_Model   = new User_Model();
        $existingUser = $User_Model->where( 'contact_no', $contact )->where( 'users_id !=', $id )->first();

        $success    = false;
        $error_type = null;

        if ( $existingUser ) {
            $error_type = 'contact_exists';
        } else {
            $existingUser = $User_Model->where( 'email', $email )->where( 'users_id !=', $id )->first();
            if ( $existingUser ) {
                $error_type = 'email_exists';
            } else {
                $updateData = [ 
                    'name'       => $name,
                    'contact_no' => $contact,
                    'email'      => $email,
                    'updated_at' => date( 'Y-m-d H:i:s' ),
                ];

                if ( !empty( $password ) ) {
                    $updateData[ 'password' ] = password_hash( $password, PASSWORD_BCRYPT );
                }

                if ( $User_Model->update( $id, $updateData ) ) {
                    $success = true;

                    $updatedUser = $User_Model->find( $id );
                    session()->set( 'user', $updatedUser );

                    session()->setFlashdata( [ 
                        'type'    => 'success',
                        'message' => 'Profile updated successfully!',
                    ] );
                } else {
                    $error_type = 'db_error';
                }
            }
        }

        return $this->response->setJSON( [ 
            'success'    => $success,
            'error_type' => $error_type,
        ] );
    }

    public function logout()
    {
        session()->remove( "user" );

        session()->setFlashdata( [ 
            "type"    => "success",
            "message" => "You have been logged out successfully."
        ] );

        return $this->response->setJSON( [ 
            "success" => true,
            "message" => "You have been logged out successfully."
        ] );
    }
}
