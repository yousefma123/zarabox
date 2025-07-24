<?php 


    class Jobs {

        public $conn, $Functions;
        
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _createJob($data, $token)
        { 
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];
                if(isset($data['structure']) && !empty($data['structure'])){
                    $structure_id = $data['structure'];
                    if($this->Functions->select('`id`', 'structures', 'fetch', "WHERE `id` = $structure_id && `status` = 1")['rowCount'] !=1 ){
                        $errors[] .= "Error in structure id";
                    }
                }else{
                    $errors[] .= "Error in structure not found";
                }
                if(!isset($data['branches']) || empty($data['branches'])){
                    $errors[] .= "Error in branches not found";
                }
                $jobs_array = array();
                if(isset($data['jobs_names'][0]) && !empty($data['jobs_names'][0])){
                    foreach($data['jobs_names'] as $job){
                        if(isset($job) && !empty(trim($job))){
                            $jobs_array[] .= $job;
                        }
                    }
                }else{
                    $errors[] .= "Error in jobs names";
                }
                if(empty($errors)){
                    $branches = implode(',', $data['branches']);
                    $insert = $this->conn->prepare("INSERT INTO `jobs` (`name`, `branches`, `structure`) VALUES(?, ?, ?)");
                    foreach($jobs_array as $job){
                        $insert->execute([
                            $job,
                            $branches,
                            $data['structure']
                        ]);
                        self::_setDefaultPermissions($this->conn->lastInsertId());
                    }
                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم إضافة الوظائف بنجاح');
                    }
                }else{
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    echo '<div class="alert alert-danger rounded-4"><div>'.$show_errors.'</div></div>';
                }
            }
        }

        private function _setDefaultPermissions($jobid)
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
                $permissions_array['page_'.$page['id']]['show'] = 'false';
                $permissions_array['page_'.$page['id']]['add'] = 'false';
                $permissions_array['page_'.$page['id']]['update'] = 'false';
                $permissions_array['page_'.$page['id']]['delete'] = 'false';
            }
            $update = $this->conn->prepare("UPDATE `jobs` SET `permissions` = ? WHERE `id` = ? LIMIT 1");
            $update->execute([json_encode($permissions_array), $jobid]);
            return $update->rowCount();
        }
    }