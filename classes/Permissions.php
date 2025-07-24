<?php 

    class Permissions {

        public $conn, $Functions;

        public function __construct()
        {
            require_once ('Connection.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _setPermissions($jobid)
        {
            $permissions_array = array();
            foreach($this->Functions->select("*", "`pages`", "fetchAll")['fetchAll'] as $page)
            {
                $permissions_array['page_'.$page['id']] = 
                [
                    "show"      => '',
                    "add"       => '',
                    "update"    => '',
                    "delete"    => '',
                ];
                
                $page_id = $page['id'];
                if(isset($_POST['show_'.$page_id.'']) && $_POST['show_'.$page_id.''] == 'on'){
                    $permissions_array['page_'.$page['id']]['show'] = 'true';
                }else{
                    $permissions_array['page_'.$page['id']]['show'] = 'false';
                }
                if(isset($_POST['add_'.$page_id.'']) && $_POST['add_'.$page_id.''] == 'on'){
                    $permissions_array['page_'.$page['id']]['add'] = 'true';
                }else{
                    $permissions_array['page_'.$page['id']]['add'] = 'false';
                }
                if(isset($_POST['update_'.$page_id.'']) && $_POST['update_'.$page_id.''] == 'on'){
                    $permissions_array['page_'.$page['id']]['update'] = 'true';
                }else{
                    $permissions_array['page_'.$page['id']]['update'] = 'false';
                }
                if(isset($_POST['delete_'.$page_id.'']) && $_POST['delete_'.$page_id.''] == 'on'){
                    $permissions_array['page_'.$page['id']]['delete'] = 'true';
                }else{
                    $permissions_array['page_'.$page['id']]['delete'] = 'false';
                }
            }
            $update = $this->conn->prepare("UPDATE `jobs` SET `permissions` = ? WHERE `id` = ? LIMIT 1");
            $update->execute([json_encode($permissions_array), $jobid]);
            if($update->rowCount() > 0){
                $this->Functions->_alert("تم إضافة الصلاحيات للوظيفة بنجاح");
            }
        }
    }
