<?php
class user extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function login($data)
        {
                $this->db->select("*")
                        ->from("users")
                        ->where("uname", $data['uname'])
                        ->where("password", $data['password'])
                        ->limit(1);
                $q = $this->db->get();
                if($q->num_rows() == 1)
                {
                        return true;
                } else {
                        return false;
                }
        }

        public function register($data)
        {
                $this->db->select("*")
                        ->from("users")
                        ->where("uname", $data["uname"])
                        ->limit(1);
                $q = $this->db->get();
                if($q->num_rows() == 0)
                {
                        $this->db->insert("users", $data);
                        if ($this->db->affected_rows() > 0)
                        {
                                return true;
                        }
                } else {
                        return false;
                }
        }

        public function get($data)
        {
                $this->db->select("*")
                        ->from("users")
                        ->where("uname", $data)
                        ->limit(1);
                $q = $this->db->get();
                if($q->num_rows() == 1)
                {
                        return $q->result();
                } else {
                        return false;
                }
        }

        public function get_by_id($data)
        {
                $this->db->select("*")
                        ->from("users")
                        ->where("uid", $data)
                        ->limit(1);
                $q = $this->db->get();
                if($q->num_rows() == 1)
                {
                        return $q->result();
                } else {
                        return false;
                }
        }

        public function get_all()
        {
                $this->db->select("uid, uname, email, firstname, lastname, website")
                        ->from("users");
                $q = $this->db->get();
                return $q->result();
        }

        public function edit($data)
        {
                $this->db->set($data)
                        ->where("uid", $data["uid"]);
                $q = $this->db->update("users", $data);
                if($q == true)
                {
                        return true;
                } else {
                        return false;
                }
        }

        public function delete($data)
        {
                $q = $this->db->delete('users', array('uid' => $data));
                if($q == true)
                {
                        return true;
                } else {
                        return false;
                }
        }
}