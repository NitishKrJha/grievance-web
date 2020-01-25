<?php
error_reporting(0);
//require('application_front/libraries/REST_Controller.php');
require(APPPATH.'libraries/REST_Controller.php');
class Api extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->controller = 'api';
		$this->load->model('ModelApi');
		$this->load->model('ModelMember');
		$this->load->model('ModelCommon');
		$this->config->load('paypal_config');	
		if (isset($_SERVER['HTTP_ORIGIN'])) {
	        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	        header('Access-Control-Allow-Credentials: true');
	        header('Access-Control-Max-Age: 86400');    // cache for 1 day
	    }

	    // Access-Control headers are received during OPTIONS requests
	    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	            header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	        exit(0);
	    }
	    $this->postdata = file_get_contents("php://input");
	}
    public function index(){
        $data = array('status' => false, 'message' => 'Ad title field is blank','data'=>array());
        $this->response($data);
    }
	public function API_Login(){
		//echo $this->postdata;
		if($this->postdata){
			$request        = json_decode($this->postdata);
			/* $username       = $request->email;
			$password       = $request->password;
			$member_type    = $request->member_type; */
			//echo $username; die();
			if($request->email !='' && $request->password!='' && $request->member_type!=''){
                $returnData = $this->ModelApi->authenticateUser($request);
				
                if(count($returnData)>0){
                    $data = array('status' => true, 'message' => 'Login successfull.','data'=>$returnData);
                }else{
                    $data = array('status' => false, 'message' => 'Invalid email or password.','data'=>array());
                }
            }else{
                $data = array('status' => false, 'message' => 'All fields are required','data'=>array());
            }
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
        $this->response($data);
	}

	public function API_getCounselorData(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else{
				$counselor_id=$request['counselor_id'];
				$details=$this->ModelApi->getCounselorData($counselor_id);
				if(count($details) > 0){
					$data = array('status' => true, 'message' => 'Data Available','data'=>$details);
				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	public function API_addCounselorAvailableTime(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else if(!$request['avalable_date']){
				$data = array('status' => false, 'message' => 'You did not pass avalable_date','data'=>array());
			}else{
				$ndata=array();
				$counselor_id=$request['counselor_id'];
				$ndata['avalable_date']=$request['avalable_date'];
				$ndata['start_time']=$request['start_time'];
				$ndata['end_time']=$request['end_time'];
				$ndata['counselor_id']=$request['counselor_id'];
				$ndata['create_date']=date('Y-m-d');
				
				$details=$this->ModelApi->getCounselorData($counselor_id);
				if(count($details) > 0){
					$checkDate=$this->ModelApi->check_counciler_available_date($counselor_id,$ndata['avalable_date'],$ndata['start_time'],$ndata['end_time']);
					if(count($checkDate) > 0){
						$data = array('status' => false, 'message' => 'You have already updated this time previously','data'=>$ndata);
					}else{
						$result=$this->ModelApi->insertData('counselor_avalable',$ndata);
						echo $this->db->last_query();
						if($result > 0){
							$data = array('status' => true, 'message' => 'Time Added Successfully','data'=>$ndata);
						}else{
							$data = array('status' => false, 'message' => 'unable to update, please try after some time','data'=>array());
						}
						
					}

				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	public function API_deleteCounselorAvailableTime(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else if(!$request['avalable_date_id']){
				$data = array('status' => false, 'message' => 'You did not pass avalable_date_id','data'=>array());
			}else{
				$counselor_id=$request['counselor_id'];
				$details=$this->ModelApi->getCounselorData($counselor_id);
				if(count($details) > 0){
					
					$result=$this->ModelApi->delData('counselor_avalable',array('id'=>$request['avalable_date_id'],'counselor_id'=>$counselor_id));
					if($result > 0){
						$data = array('status' => true, 'message' => 'Deleted Successfully','data'=>array());
					}else{
						$data = array('status' => false, 'message' => 'Already Deleted Previouly
							','data'=>array());
					}
				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	public function API_listCounselorAvailableTime(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			$page = isset($request['page'])?$request['page']:0;;
			$limit = 20;
			if($page > 0)
			{
				$page = $page*$limit;
			}
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else{
				$ndata=array();
				$counselor_id=$request['counselor_id'];
				
				$details = $this->db->where('counselor_id',$counselor_id)->limit($limit,$page)->order_by('avalable_date','desc')->get('counselor_avalable')->result_array();
				if(count($details) > 0){
					
					foreach($details as $k=>$val)
					{
						$details[$k]['start_time'] = date('h:i:s a',strtotime($val['start_time']));
						$details[$k]['end_time'] = date('h:i:s a',strtotime($val['end_time']));
					}
					
					$data = array('status' => true, 'message' => 'Data Available','data'=>$details);
				}else{
					$data = array('status' => false, 'message' => 'You did not set any time yet','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}



	public function API_loginCounselor(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['email']){
				$data = array('status' => false, 'message' => 'Please enter email','data'=>array());
			}else if(!$request['password']){
				$data = array('status' => false, 'message' => 'Please enter password','data'=>array());
			}else{
				$email=$request['email'];
				$password=$request['password'];
				$details=$this->ModelApi->authenticateCounselor($email,$password);
				if(count($details) > 0){
					$data = array('status' => true, 'message' => 'Data Available','data'=>$details);
				}else{
					$data = array('status' => false, 'message' => 'Invalid email or password','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	public function API_counselorProfileUpdate(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else if(!$request['about_me']){
				$data = array('status' => false, 'message' => 'You did not pass about_me','data'=>array());
			}else if(!$request['profile_heading']){
				$data = array('status' => false, 'message' => 'You did not pass profile_heading','data'=>array());
			}else if(!$request['name']){
				$data = array('status' => false, 'message' => 'You did not pass name','data'=>array());
			}else{
				$ndata=array();
				$counselor_id=$request['counselor_id'];
				$ndata['profile_heading']=$request['profile_heading'];
				$ndata['about_me']=$request['about_me'];
				$ndata['name']=$request['name'];
				$details=$this->ModelApi->getCounselorData($counselor_id);
				if(count($details) > 0){
					$result=$this->ModelApi->updateData('member',$ndata,array('id'=>$counselor_id));
					if($result > 0){
						$data = array('status' => true, 'message' => 'profile Updated Successfully','data'=>$ndata);
					}else{
						$data = array('status' => false, 'message' => 'unable to update, please try after some time','data'=>array());
					}
				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	function API_counselorCertificateDelete(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else if(!$request['certificate_id']){
				$data = array('status' => false, 'message' => 'You did not pass certificate_id','data'=>array());
			}else{
				$counselor_id=$request['counselor_id'];
				$details=$this->ModelApi->getCounselorData($counselor_id);
				pr($details);
				if(count($details) > 0){
					$certificate_id=$request['certificate_id'];
					$tblname="counselor_certificates";
					$picData=$this->ModelApi->getSingleData('counselor_certificates',array('id'=>$certificate_id,'member_id'=>$counselor_id));
					$explodepic=explode("/uploads", $picData['certificate']);
					if(count($picData) > 0){
						$result=$this->ModelApi->delData($tblname,array('id'=>$certificate_id));
						if($result > 0){
							if(isset($explodepic[1])){
								$imgpath=file_upload_absolute_path().$explodepic[1];
								if(is_file($imgpath)){
							       unlink($imgpath);
							    }
							}
							$data = array('status' => true, 'message' => 'Deleted Successfully','data'=>$ndata);
						}else{
							$data = array('status' => false, 'message' => 'unable to delete, please try after some time','data'=>array());
						}
					}else{
						$data = array('status' => false, 'message' => 'This selected picture is already deleted previously','data'=>array());
					}
					
				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	function API_counselorCertificateAdd(){
		if($_REQUEST['counselor_id']){
			$member_id=$_REQUEST['counselor_id'];
			if(count($_FILES["certificate"]["name"])>0)
	        {
		        $config["upload_path"] = file_upload_absolute_path().'counselor_certificate/';
		        $config["allowed_types"] = 'gif|jpg|png';
		        $this->upload->initialize($config);
	        	for($count = 0; $count<count($_FILES["certificate"]["name"]); $count++)
	        	{
		            $_FILES["certificates"]["name"]      = time().$_FILES["certificate"]["name"][$count];
		            $_FILES["certificates"]["type"]      = $_FILES["certificate"]["type"][$count];
		            $_FILES["certificates"]["tmp_name"]  = $_FILES["certificate"]["tmp_name"][$count];
		            $_FILES["certificates"]["error"]     = $_FILES["certificate"]["error"][$count];
		            $_FILES["certificates"]["size"]      = $_FILES["certificate"]["size"][$count];
		            if($this->upload->do_upload('certificates'))
		            {
		                //$certificateData[] = $this->upload->data();
						$Imgdata1 = $this->upload->data();
						
		                $certificateData[$count]['certificate'] = file_upload_base_url().'counselor_certificate/'.$Imgdata1["file_name"];
		                $certificateData[$count]['member_id'] = $member_id;
		            }
	        	}

	        	if(count($certificateData) > 0){
	        		$this->ModelApi->addcertificate($certificateData);
	        		$data = array('status' => true, 'message' => 'Certificate added Successfully','data'=>array());
	        	}else{
	        		$data = array('status' => false, 'message' => 'Certificate file should not be blank','data'=>array());
	        	}
	    	}
		}else{
			$data = array('status' => false, 'message' => 'Invalid Request','data'=>array());
		}
	    
		$this->response($data);		
	}

	public function removePicture(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else if(!$request['pic_id']){
				$data = array('status' => false, 'message' => 'You did not pass pic_id','data'=>array());
			}else if(!$request['type']){
				$data = array('status' => false, 'message' => 'You did not pass type','data'=>array());
			}else{
				$counselor_id=$request['counselor_id'];
				$details=$this->ModelApi->getCounselorData($counselor_id);
				if(count($details) > 0){
					$type=$request['type'];
					$pic_id=$request['pic_id'];
					if($type=="profile_photo"){
						$tblname="member_photo";
						$picData=$this->ModelApi->getSingleData('member_photo',array('id'=>$pic_id,'member_id'=>$counselor_id));
						$explodepic=explode("/uploads", $picData['photo']);
					}else{
						$tblname="counselor_certificates";
						$picData=$this->ModelApi->getSingleData('counselor_certificates',array('id'=>$pic_id,'member_id'=>$counselor_id));
						$explodepic=explode("/uploads", $picData['certificate']);
					}
					
					
					if(count($picdata) > 0){
						
						$result=$this->ModelApi->delData($tblname,array('id'=>$pic_id));
						if($result > 0){
							if(isset($explodepic[1])){
								$imgpath=file_upload_absolute_path().$explodepic[1];
								if(is_file($imgpath)){
							       unlink($imgpath);
							    }
							}
							$data = array('status' => true, 'message' => 'Deleted Successfully','data'=>$ndata);
						}else{
							$data = array('status' => false, 'message' => 'unable to delete, please try after some time','data'=>array());
						}
					}else{
						$data = array('status' => false, 'message' => 'This selected picture is already deleted previously','data'=>array());
					}
					
				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	public function removeVideo(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['counselor_id']){
				$data = array('status' => false, 'message' => 'You did not pass counselor_id','data'=>array());
			}else if(!$request['video_id']){
				$data = array('status' => false, 'message' => 'You did not pass video_id','data'=>array());
			}else{
				$counselor_id=$request['counselor_id'];
				$details=$this->ModelApi->getCounselorData($counselor_id);
				if(count($details) > 0){
					$type=$request['type'];
					$video_id=$request['video_id'];
					$tblname="member_video";
					$picData=$this->ModelApi->getSingleData('member_video',array('id'=>$video_id,'member_id'=>$counselor_id));
					
					
					if(count($picdata) > 0){
						
						$result=$this->ModelApi->delData($tblname,array('id'=>$video_id));
						if($result > 0){
							if(isset($explodepic[1])){
								$imgpath=file_upload_absolute_path().$explodepic[1];
								if(is_file($imgpath)){
							       unlink($imgpath);
							    }
							}
							$data = array('status' => true, 'message' => 'Deleted Successfully','data'=>$ndata);
						}else{
							$data = array('status' => false, 'message' => 'unable to delete, please try after some time','data'=>array());
						}
					}else{
						$data = array('status' => false, 'message' => 'This selected Video is already deleted previously','data'=>array());
					}
					
				}else{
					$data = array('status' => false, 'message' => 'This Counselor is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

	public function removeVideoForMember(){
		if($this->postdata){
			$request        = json_decode($this->postdata,true);
			if(!$request['member_id']){
				$data = array('status' => false, 'message' => 'You did not pass member_id','data'=>array());
			}else if(!$request['video_id']){
				$data = array('status' => false, 'message' => 'You did not pass video_id','data'=>array());
			}else{
				$member_id=$request['member_id'];
				$details=$this->ModelApi->getSingleData('member',array('id'=>$member_id));
				if(count($details) > 0){
					$type=$request['type'];
					$video_id=$request['video_id'];
					$tblname="member_video";
					$picData=$this->ModelApi->getSingleData('member_video',array('id'=>$video_id,'member_id'=>$member_id));
					if(count($picData) > 0){
						$explodepic=explode("/uploads", $picData['photo']);
						$result=$this->ModelApi->delData($tblname,array('id'=>$video_id));
						if($result > 0){
							if(isset($explodepic[1])){
								$imgpath=file_upload_absolute_path().$explodepic[1];
								if(is_file($imgpath)){
							       unlink($imgpath);
							    }
							}
							$data = array('status' => true, 'message' => 'Deleted Successfully','data'=>array());
						}else{
							$data = array('status' => false, 'message' => 'unable to delete, please try after some time','data'=>array());
						}
					}else{
						$data = array('status' => false, 'message' => 'This selected Video is already deleted previously','data'=>array());
					}
					
				}else{
					$data = array('status' => false, 'message' => 'This member is not available in our database','data'=>array());
				}
			}
		}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);
	}

    public function API_RegStep1(){
        if($this->postdata){
            $request        = json_decode($this->postdata);

            $returnEmailData = $this->ModelMember->checkEmail($request->email);
            $returnPhoneData = $this->ModelMember->checkPhoneNo($request->phone_no);
            if(count($returnEmailData)>0){
                $data = array('status' => false, 'message' => 'Email already exits.','data'=>array());
            }else if(count($returnPhoneData)>0){
                $data = array('status' => false, 'message' => 'Phone No. already exits.','data'=>array());
            }else{
                $data['member_type']		    = 1;
                $data['email'] 				    = $request->email;
                $data['man_woman']              = $request->man_woman;
                $data['maritial_status']        = $request->maritial_status;
                $data['interested_in']          = $request->interested_in;
                $data['phone_no']               = $request->phone_no;
                $data['password'] 			    = md5($request->password);
                $data['created']			    = date('Y-m-d H:i:s');
                $data['expire_date']			= date('Y-m-d H:i:s', strtotime($data['created']. ' + 1 days'));

                /*Generate OTP*/

                $string = '0123456789';
                $string_shuffled = str_shuffle($string);
                $otp = substr($string_shuffled, 1, 7);
				$data['otp'] = $otp;

                //$insert_id 					    = $this->ModelMember->memberReg($data);
				
                $insert_id 					    = $this->ModelApi->memberReg($data);
				
                if($insert_id){
                    /**Send Registration Mail**/
         //            $step2Link      = base_url('member/step2/'.base64_encode($insert_id));
         //            $to 			= $data['email'];
         //            $subject		= "Registration";
         //            $body			= "<tr><td>Hi,</td></tr>
									// <tr><td>Thanks for opening an account on our platform.Please click on link to complete your profile <a href='".$step2Link."'>Click here</a> </td></tr>";
         //            $this->functions->mail_template($to,$subject,$body);

                    /**Send OTP Mail**/
                    $to 			= $data['email'];
                    $subject		= "MMR Registration OTP";
                    $body1			= "<tr><td>Hi,</td></tr>
									<tr><td>Your OTP is ".$otp."</td></tr>";
					$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
		                  <tbody style="color: #fff;">
		                    <tr>
		                      <td colspan="3" width="600" height="10" align="left" />
		                    </tr>
		                    <tr style="text-align:center;">
		                      <td width="13" align="left"/>
		                      <td width="13" align="left"/>
		                    </tr>
		                    '.$body1.'
		                  </tbody>
		                </table></td>';
                    $this->functions->mail_template($to,$subject,$body);
                    $data = array('status' => true, 'message' => 'Registration successfull.','data'=>array('id'=>$insert_id,'otpCode'=>$otp,'email'=>$request->email));
                }else{
                    $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
                }
            }
        }else{
            $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
        }
        $this->response($data);
    }
    function API_checkUsername(){
        if($this->postdata){
            $request        = json_decode($this->postdata);
            $username       = $request->username;
            if($username !=''){
                $return = $this->ModelMember->checkUsername($username);
                if(count($return)>0){
                    $data = array('status' => false, 'message' => 'Username already exist.','data'=>array());
                }else{
                    $data = array('status' => true, 'message' => 'You can use this username','data'=>array());
                }
            }else{
                $data = array('status' => false, 'message' => 'All fields are required','data'=>array());
            }
        }else{
            $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
        }
        $this->response($data);
    }
	
	
	
	
	
	
	
	function API_forgetpwd(){
		
		  if($this->postdata){
		   //$request =' {"email":"sudip.karmakar@vaptech.in"}';
		    $request        = json_decode($this->postdata);
		    //$request        = json_decode('{"email":"sudip.karmakar@vaptech.in"}');
            $email       = $request->email;
			
			$check_email = $this->ModelApi->checkEmail($email);
			
			if(count($check_email)>0){
				
				$insertoken=$this->ModelApi->inserttokenforpassword($email);
				
				$link=base_url()."login/password?email=".$email."&token=".base64_encode($insertoken);
				$to = $email;
				$subject="Forgot Password";
				$body="<tr><td>Hi ".$check_email[0]['username'].",</td></tr>
						<tr><td>Please click below link to create a new password.</td></tr>
						<tr><td><a href='".$link."'>Click here</a></td></tr>";
				$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
		                  <tbody style="color: #fff;">
		                    <tr>
		                      <td colspan="3" width="600" height="10" align="left" />
		                    </tr>
		                    <tr style="text-align:center;">
		                      <td width="13" align="left"/>
		                      <td width="13" align="left"/>
		                    </tr>
		                    '.$body1.'
		                  </tbody>
		                </table></td>';
				$return_check = $this->functions->mail_template($to,$subject,$body);
				
				if($insertoken){
                $data = array('status' => true, 'message' => 'Please check your mail and follow the mentioned link to reset your password','data'=>array());
				 
                }else{
                    $data = array('status' => false, 'message' => 'Please try again later','data'=>array());          
                }
				
				
			}else{
                    $data = array('status' => false, 'message' => 'This mail id is not registered with us. Kindly enter your registered email id.','data'=>array());
                }
				
		  }
			else{
            $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
        }
		
		$this->response($data);
	}
	
	function API_tips(){
		
			if($this->postdata){			
				 $request        = json_decode($this->postdata);
				 $page       = $request->page;					 
				 $returnData = $this->ModelApi->getalltips($page);
				 
				 //$returnData['tips_image'] = file_upload_base_url().'tips_image/' .$returnData[0]['icon'];
				    $data = array('status' => true, 'message' => ' Tips List','data'=> $returnData);				
				
			}
			else{
				 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);  
	}
	
	function API_tipsdetails(){
		
		if($this->postdata){		
		    $request        = json_decode($this->postdata);		    
            $id       = $request->id;			
			$returnData = $this->ModelApi->gettipsdetails($id);
			if($returnData){
				$returnData['tips_image'] = file_upload_base_url().'tips_image/' .$returnData['icon'];
				$data = array('status' => true, 'message' => ' Tips Details','data'=> $returnData);
			}else{
				$data = array('status' => false, 'message' => 'No data found','data'=>array());
			}
			
		}else{
			  $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}

		$this->response($data);  
	}
	function API_varifyotp(){
		
		if($this->postdata){
			
			$request        = json_decode($this->postdata);
		    //$request        = json_decode('{"email":"sudip.karmakar@vaptech.in"}');
            $email       = $request->email;
            $otp       = $request->otp;
			
			$check_email = $this->ModelApi->checkEmail($email);
			
			if(count($check_email)>0){
				
				$this->ModelApi->success_varify($otp);
					
				$check_otp = $this->ModelApi->checkotp($request);
				if($check_otp){
					
					$data = array('status' => true, 'message' => 'OTP verified successfully','data'=>$check_otp);
				}else{
					$data = array('status' => false, 'message' => 'You have entered invalid OTP.','data'=>array());
				}
			
			}else{
				$data = array('status' => false, 'message' => 'This mail id is not registered with us. Kindly enter your registered email id.','data'=>array());
              }
		
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		
		$this->response($data);  
	}
	
	public function API_RegStep2(){
		//pr($_POST);
		if(isset($_FILES) && $_FILES!=array())
		{
			
		
		if(isset($_REQUEST['username'])=='')
		{
			$data = array('status' => false, 'message' => 'User name can not be blank','data'=>array());
			echo json_encode($data);
		}
		else if(isset($_REQUEST['profile_heading'])=='')
		{
			$data = array('status' => false, 'message' => 'Profile heading can not be blank','data'=>array());
			echo json_encode($data);
		}
		else if(isset($_REQUEST['dob'])=='')
		{
			$data = array('status' => false, 'message' => 'Date of birth can not be blank','data'=>array());
			echo json_encode($data);
		}
		else if(isset($_REQUEST['lifestyle'])=='')
		{
			$data = array('status' => false, 'message' => 'Lifestyle can not be blank','data'=>array());
			echo json_encode($data);
		}
		
		else if(isset($_REQUEST['about_me'])=='')
		{
			$data = array('status' => false, 'message' => 'About me can not be blank','data'=>array());
			echo json_encode($data);
		}
		
		else if(isset($_REQUEST['describe_looking_for'])=='')
		{
			$data = array('status' => false, 'message' => 'Describe Loking for can not be blank','data'=>array());
			echo json_encode($data);
		}
		
		else if(isset($_REQUEST['profile_step'])=='')
		{
			$data = array('status' => false, 'message' => 'Profile step can not be blank','data'=>array());
			echo json_encode($data);
		}
		
		else if(isset($_REQUEST['success_step'])=='')
		{
			$data = array('status' => false, 'message' => 'Success step can not be blank','data'=>array());
			echo json_encode($data);
		}
		
		else
		{
			/******************File Upload*****/
			  $this->load->library('image_lib');
        	  $config['image_library']    = 'GD2';
			  $file_name = $_FILES['picture']['name'];
				//print_r($_FILES);
				//die();
			  $new_file_name = time().$file_name;
			  
			  //$config['upload_path']   = $this->config->config["server_absolute_path"].'uploads/';
			  $config['upload_path']   = file_upload_absolute_path().'profile_pic/';
			  $config['allowed_types'] = 'gif|jpg|png|jpeg';
			  //$config['max_size']      = 1024; 
			  //$config['max_width']     = 1024; 
			  //$config['max_height']    = 768;  
			  $config['file_name']     = $new_file_name;  
			  
			
			  $this->upload->initialize($config);
			  
			  if(!$this->upload->do_upload('picture')) {
			   $error = array('error' => $this->upload->display_errors()); 
			  
			  }
			  else{ 
			   $licencedata = array('upload_data' => $this->upload->data()); 
			  
			  } 
			  
			  if($licencedata['upload_data']['file_name']) {
			    //$_REQUEST['picture'] = $licencedata['upload_data']['file_name'];
			    $_REQUEST['picture'] = file_upload_base_url().'profile_pic/'.$licencedata['upload_data']['file_name'];
			  	$upload_data = $licencedata;
	            $dataSet = $licencedata['upload_data'];
	            $Imgdata = $licencedata['upload_data'];
	            $source_path = file_upload_absolute_path() . 'profile_pic/' . $dataSet["file_name"];
	            $target_path = file_upload_absolute_path() . '/profile_pic/tmp/' . $dataSet["file_name"];
	            $configer = array(
	                'image_library' => 'gd2',
	                'source_image' => $source_path,
	                'new_image' => $target_path,
	                'maintain_ratio' => TRUE,
	                'create_thumb' => TRUE,
	                'width' => 223,
	                'height' => 247
	            );
	            $this->image_lib->initialize($configer);
	            $this->image_lib->resize();
	            $this->image_lib->clear();
	            $Imgdata['thamble_image'] = $dataSet['file_name'];
	            $implodeData = explode('.',$licencedata['upload_data']['file_name']);
				$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
				$_REQUEST['crop_profile_image'] = file_upload_base_url().'/profile_pic/tmp/'.$thumbImgNme;
			  }else{
			   
			   $_REQUEST['picture'] = "";
			   $_REQUEST['crop_profile_image']='';
			  }
				   /***********End Image I****/
				   
				   
		 unset($_REQUEST['/api/API_RegStep2']);   
	     $result = $this->ModelApi->doSaveProfileData($_REQUEST['id'],$_REQUEST);
		 if($result){
			 $data = array('status' => true, 'message' => 'Second step completed','data'=>array());
			
		 }
		}
		}				
		$this->response($data);
	}
	
	function API_mymatch(){		
		if($this->postdata){			
			$request        = json_decode($this->postdata);		   
            $page       = $request->page;
            //$id       = $request->id;
			
			$result = $this->ModelApi->mymatch($request,$page);
			if($result)
			{
				$data = array('status' => true, 'message' => 'Success','data'=>$result);
			}else{
				 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}
			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data);  		
	}
	
	function API_mymatchDetails()
	{
		if($this->postdata){
			
			$request        = json_decode($this->postdata);		   
            $id       = $request->id;
			$member_id       = $request->member_id;
			$result = $this->ModelApi->mymatchDetails($id);
			$is_favourite = $this->db->where('member_id',$member_id)->where('favorite_member_id',$id)->get('my_favorite')->result_array();
			
			if(!empty($is_favourite))
			{
				$status = 1;
			}
			else{
				$status = 0;
			}
			if($result){
				$response['details'] = $result;
				$response['is_favourite'] = $status;
				$data = array('status' => true, 'message' => 'Member Details','data'=>$response);
			}else{
			 $data = array('status' => false, 'message' => 'No Data found','data'=>array());
		}
			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		
		$this->response($data);  
	}
	
	function API_resetpassword(){
		if($this->postdata){			
			$request        = json_decode($this->postdata);				          
			$password = $request->password;
			$confirmpass = $request->confirmpass;
			$oldpassword = $request->oldpassword;
			$checkOldPassword=$this->ModelApi->getSingleData('member',array('password'=>md5($oldpassword)));
			if(count($checkOldPassword) > 0){
				if($password ==$confirmpass){
					$result = $this->ModelApi->resetpassword($request);
					$data = array('status' => true, 'message' => 'Successfully Reset your password','data'=>array());
					
				} else {
					
				  $data = array('status' => false, 'message' => 'Password and Confirm password not match','data'=>array());
				}
			}else{
				$data = array('status' => false, 'message' => 'Your old password is invalid','data'=>array());
			}
			
			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		
		$this->response($data);  
	}
	
	function API_resentotp(){
		
		
		if($this->postdata){
			
			$request        = json_decode($this->postdata);
		    //$request        = json_decode('{"email":"sudip.karmakar@vaptech.in"}');
            $email       = $request->email;
		
				$check_email = $this->ModelApi->checkEmail($email);
			
			if(count($check_email)>0){
				
				$string = '0123456789';
                $string_shuffled = str_shuffle($string);
                $otp = substr($string_shuffled, 1, 7);
				//$data['otp'] = $otp;

                //$insert_id 					    = $this->ModelMember->memberReg($data);
				
                $insert_id 					    = $this->ModelApi->resentotp($otp,$email);
				
                
                    /**Send Registration Mail**/
                    /* $step2Link      = base_url('member/step2/'.base64_encode($insert_id));
                    $to 			= $data['email'];
                    $subject		= "Registration";
                    $body			= "<tr><td>Hi,</td></tr>
									<tr><td>Thanks for opening an account on our platform.Please click on link to complete your profile <a href='".$step2Link."'>Click here</a> </td></tr>";
                    $this->functions->mail_template($to,$subject,$body);
 */
                    /**Send OTP Mail**/
                    $to 			= $email;
                    $subject		= "MMR Registration OTP";
                    $body1			= "<tr><td>Hi ".$check_email[0]['username'].",</td></tr>
									<tr><td>Your OTP is ".$otp."</td></tr>";
					$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
		                  <tbody style="color: #fff;">
		                    <tr>
		                      <td colspan="3" width="600" height="10" align="left" />
		                    </tr>
		                    <tr style="text-align:center;">
		                      <td width="13" align="left"/>
		                      <td width="13" align="left"/>
		                    </tr>
		                    '.$body1.'
		                  </tbody>
		                </table></td>';				
                    $this->functions->mail_template($to,$subject,$body);
                    $data = array('status' => true, 'message' => 'OTP successfully resent.','data'=>array('otpCode'=>$otp,'email'=>$request->email));
			}else{
				$data = array('status' => false, 'message' => 'This mail id is not registered with us. Kindly enter your registered email id.','data'=>array());
              }	
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data);  
	}
	
	function API_search(){
		
		if($this->postdata){			
			$request        = json_decode($this->postdata);
			$page       = $request->page;
			
			$result = $this->ModelApi->search($request,$page);
			
			if($result)
			{
				$data = array('status' => true, 'message' => 'Success','data'=>$result);
			}else{
				 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
	}
	
	function API_counselor()
	{		
		if($this->postdata){
			
			$request        = json_decode($this->postdata);			
			$returnData = $this->ModelApi->getallcounselor($request->page,$request);
			if($returnData){				
				$data = array('status' => true, 'message' => ' Counselor List','data'=> $returnData);
			}else{
			 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}			
		$this->response($data); 
	}
	
	function API_country(){
		
		$returnData = $this->ModelApi->getallcountry();
		$data = array('status' => true, 'message' => 'Country List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_state(){
		
		if($this->postdata){			
			$request        = json_decode($this->postdata);			
				 $id       = $request->id;				
				$returnData = $this->ModelApi->getstate($id);				
			if($returnData){
				$data = array('status' => true, 'message' => 'State List','data'=> $returnData);
			}else{
			 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
	}
	
	function API_city()
	{
		if($this->postdata){			
			$request        = json_decode($this->postdata);			
				 $id       = $request->id;				
				$returnData = $this->ModelApi->getcity($id);				
			if($returnData){
				$data = array('status' => true, 'message' => 'City List','data'=> $returnData);
			}else{
			 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
	}
	
	function API_ethnicity(){
		
		$returnData = $this->ModelApi->getallethnicity();
		
		$data = array('status' => true, 'message' => 'Ethnicity List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_faith(){
		
		$returnData = $this->ModelApi->getallfaith();		
		$data = array('status' => true, 'message' => 'Faith List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_language()
	{
		$returnData = $this->ModelApi->getalllanguage();		
		$data = array('status' => true, 'message' => 'Language List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_education(){
		
		$returnData = $this->ModelApi->getalleducation();		
		$data = array('status' => true, 'message' => 'Education List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_eyetype(){
		
		$returnData = $this->ModelApi->getalleyetype();		
		$data = array('status' => true, 'message' => 'Eye Type List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_hairtype(){
		
		$returnData = $this->ModelApi->getallhairtype();		
		$data = array('status' => true, 'message' => 'Hair Type List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_outdooractivities(){
		
		$returnData = $this->ModelApi->getAllOutdoorActivities();		
		$data = array('status' => true, 'message' => 'Outdoor Activities List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_indooractivities(){
		
		$returnData = $this->ModelApi->getAllIndoorActivities();		
		$data = array('status' => true, 'message' => 'Indoor Activities List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_vacationplace(){
		
		$returnData = $this->ModelApi->getAllVacationPlace();		
		$data = array('status' => true, 'message' => 'Vacation Place List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_bodytype(){
		
		$returnData = $this->ModelApi->getAllBodyType();		
		$data = array('status' => true, 'message' => 'Body type List','data'=> $returnData);
		$this->response($data);
		
	}
	
	function API_updateappearence(){
		
		if($this->postdata){
			
			$request        = json_decode($this->postdata);
			
			/* $memberMoreData = array();
			$memberData = array(); */
			
			$member_id = $request->id;
			
			if(isset($request->name)&& $request->name!=''){	
				
				$memberData['name'] = $request->name;
			}
			
			if(isset($request->about_me)&& $request->about_me!=''){	
				
				$memberData['about_me'] = $request->about_me;
			}
			
			if(isset($request->country)&& $request->country!=''){	
				
				$memberData['country'] = $request->country;
			}
			
			if(isset($request->state)&& $request->state!=''){	
				
				$memberData['state'] = $request->state;
			}
			
			if(isset($request->city)&& $request->city!=''){	
				
				$memberData['city'] = $request->city;
			}
			
			if(isset($request->zip)&& $request->zip!=''){	
				
				$memberData['zip'] = $request->zip;
			}
			
			if(isset($request->age)&& $request->age!=''){	
				
				$memberData['age'] = $request->age;
			}
			
			if(isset($request->interested_in)&& $request->interested_in!=''){	
				
				$memberData['interested_in'] = $request->interested_in;
			}
			
			if(isset($request->height)&& $request->height!=''){	
				
				$memberMoreData['height'] = $request->height;
			}
			
			if(isset($request->body_type)&& $request->body_type!=''){	
				
				$memberMoreData['body_type'] = $request->body_type;
			}
			
			if(isset($request->hair)&& $request->hair!=''){	
				
				$memberMoreData['hair'] = $request->hair;
			}
			
			if(isset($request->eye)&& $request->eye!=''){	
				
				$memberMoreData['eye'] = $request->eye;
			}
			
			$result = $this->ModelApi->doSaveAppearanceData($member_id,$memberData,$memberMoreData);
			
			if($result){				
				$data = array('status' => true, 'message' => 'Appearence Successfully Update','data'=>array());
			}
			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data);
		
	}
	
	function API_updatelifestyle(){
		
		if($this->postdata){
			
			$request        = json_decode($this->postdata);
			
			$member_id = $request->id;
			
			if(isset($request->smoking)&& $request->smoking!=''){	
				
				$memberMoreData['smoking'] = $request->smoking;
			}
			
			if(isset($request->drinking)&& $request->drinking!=''){	
				
				$memberMoreData['drinking'] = $request->drinking;
			}
			
			if(isset($request->occupation)&& $request->occupation!=''){	
				
				$memberMoreData['occupation'] = $request->occupation;
			}
			
			if(isset($request->income)&& $request->income!=''){	
				
				$memberMoreData['income'] = $request->income;
			}
			
			$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);
			
			if($result){				
				$data = array('status' => true, 'message' => 'Lifestyle Successfully Update','data'=>array());
			}
			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data);
	}
	
	function API_updaterelationship(){
		
		if($this->postdata){
			
			$request        = json_decode($this->postdata);			
			$member_id = $request->id;			
			if(isset($request->have_kids)&& $request->have_kids!=''){					
				$memberMoreData['have_kids'] = $request->have_kids;
			}			
			if(isset($request->want_kids)&& $request->want_kids!=''){					
				$memberMoreData['want_kids'] = $request->want_kids;
			}			
			$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);			
			if($result){				
				$data = array('status' => true, 'message' => 'Relationship Successfully Update','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		
		$this->response($data);
	}
	
	function  API_updatebackground(){
			
			if($this->postdata){
			
				$request        = json_decode($this->postdata);			
				$member_id = $request->id;
				
				if(isset($request->ethnicity)&& $request->ethnicity!=''){					
					$memberMoreData['ethnicity'] = $request->ethnicity;
				}
				
				if(isset($request->faith)&& $request->faith!=''){					
					$memberMoreData['faith'] = $request->faith;
				}
				
				if(isset($request->language)&& $request->language!=''){					
					$memberMoreData['language'] = $request->language;
				}
				
				if(isset($request->country)&& $request->country!=''){					
					$memberMoreData['country'] = $request->country;
				}
				
				if(isset($request->state)&& $request->state!=''){					
					$memberMoreData['state'] = $request->state;
				}
				
				if(isset($request->city)&& $request->city!=''){					
					$memberMoreData['city'] = $request->city;
				}
				
				if(isset($request->education)&& $request->education!=''){					
					$memberMoreData['education'] = $request->education;
				}
				
				$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);
				
				if($result){
					
					$data = array('status' => true, 'message' => 'Background Successfully Update','data'=>array());
				}
			
			}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}
			
			$this->response($data);
	}
	
	function API_activities(){
		
		if($this->postdata){			
			$request        = json_decode($this->postdata);				
			$member_id = $request->id;	

			$memberMoreData['indoor_activities'] = $request->indoor_activities;
			$memberMoreData['outdoor_activities'] = $request->outdoor_activities;			
			$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);	
			
			if($result){					
				$data = array('status' => true, 'message' => 'Activities/Exercise Successfully Update','data'=>array());
			}			
			}else{
			  $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}
			
		$this->response($data);
	}
	
	function API_profilepic(){
		
		if(isset($_FILES) && $_FILES!=array())
		{
		
			/******************File Upload*****/
			$this->load->library('image_lib');
        	$config['image_library']    = 'GD2';
			$file_name = $_FILES['picture']['name'];
			$new_file_name = time().$file_name;
			$config['upload_path']   = file_upload_absolute_path().'profile_pic/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
		  	$config['file_name']     = $new_file_name;  
		  	$this->upload->initialize($config);
		  	if(!$this->upload->do_upload('picture')) {
		   		$error = array('error' => $this->upload->display_errors()); 
		  	}
		    else{ 
		   		$licencedata = array('upload_data' => $this->upload->data());
		   		$dataSet = $this->upload->data();
	            $Imgdata = $this->upload->data();
	            $source_path = file_upload_absolute_path() . 'profile_pic/' . $dataSet["file_name"];
	            $target_path = file_upload_absolute_path() . '/profile_pic/tmp/' . $dataSet["file_name"];
	            $configer = array(
	                'image_library' => 'gd2',
	                'source_image' => $source_path,
	                'new_image' => $target_path,
	                'maintain_ratio' => TRUE,
	                'create_thumb' => TRUE,
	                'width' => 280,
	                'height' => 280
	            );
	            $this->image_lib->initialize($configer);
	            $this->image_lib->resize();
	            $this->image_lib->clear();
	            $Imgdata['thamble_image'] = $dataSet['file_name'];
		  	} 
		  	if($licencedata['upload_data']['file_name']) {
		   		$profile_image = file_upload_base_url() . 'profile_pic/' .$licencedata['upload_data']['file_name'];
				$picdata['picture'] = $profile_image;
				$implodeData = explode('.',$licencedata['upload_data']['file_name']);
				$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
				$picdata['crop_profile_image'] = file_upload_base_url().'/profile_pic/tmp/'.$thumbImgNme;
				$result = $this->ModelApi->doSaveProfileData($_REQUEST['id'],$picdata);
				if($result){
				 	$data = array('status' => true, 'message' => 'successfully change profile image','data'=>array());
				}else{
					$data = array('status' => false, 'message' => 'image did not upload , please try once after some time','data'=>array());
				}	
		  	}else{

			   $data = array('status' => false, 'message' => 'image did not upload , please try once after some time','data'=>array());
		  	}
			
		}
		else{
		  $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
					
		$this->response($data);		
	}
	
	function API_coverImage(){
		
		if(isset($_FILES) && $_FILES!=array())
		{
		
		/******************File Upload*****/
		  $file_name = $_FILES['cover_image']['name'];
			//print_r($_FILES);
			//die();
		  $new_file_name = time().$file_name;
		  
		  //$config['upload_path']   = $this->config->config["server_absolute_path"].'uploads/';
		  $config['upload_path']   = file_upload_absolute_path().'cover_image/';
		  $config['allowed_types'] = 'gif|jpg|png|jpeg';
		  //$config['max_size']      = 1024; 
		  //$config['max_width']     = 1024; 
		  //$config['max_height']    = 768;  
		  $config['file_name']     = $new_file_name;  
		  
		
		  $this->upload->initialize($config);
		  
		  if(!$this->upload->do_upload('cover_image')) {
		   $error = array('error' => $this->upload->display_errors()); 
		  
		  }
		  else{ 
		   $licencedata = array('upload_data' => $this->upload->data()); 
		  
		  } 
		  
		  if($licencedata['upload_data']['file_name']) {
		   $profile_image = file_upload_base_url().'cover_image/' .$licencedata['upload_data']['file_name'];
			
			$profile_image_data['cover_image'] = $profile_image;
			$result = $this->ModelApi->doSaveProfileData($_REQUEST['id'],$profile_image_data);
			if($result){
				$data = array('status' => true, 'message' => 'successfully change Cover image','data'=>array());						
			}else{
				$data = array('status' => false, 'message' => 'image did not upload , please try once after some time','data'=>array());
			}	
		  }else{
		  	$data = array('status' => false, 'message' => 'image did not upload , please try once after some time','data'=>array());	
		  }

		  /***********End Image I****/
		}
		else{
		  $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}						
		$this->response($data);		
	}
	
	function API_petlist(){
		
		$returnData = $this->ModelApi->getallpet();		
		$data = array('status' => true, 'message' => 'Pet List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_updatepet(){
		
              if($this->postdata){				  
				$request        = json_decode($this->postdata);			
				$member_id = $request->id; 
				$memberMoreData['pet'] = $request->pet;
				$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);	

				if($result){					
					$data = array('status' => true, 'message' => 'Pet Successfully Update','data'=>array());
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_updatezodiac(){
		
              if($this->postdata){				  
				$request        = json_decode($this->postdata);			
				$member_id = $request->id; 
				$memberMoreData['sign'] = $request->zodiac;
				$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);	

				if($result){					
					$data = array('status' => true, 'message' => 'zodiac Successfully Update','data'=>array());
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_updatepolitics(){
		
              if($this->postdata){				  
				$request        = json_decode($this->postdata);			
				$member_id = $request->id; 
				$memberMoreData['politics_view'] = $request->politics;
				$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);	

				if($result){					
					$data = array('status' => true, 'message' => 'politics Successfully Update','data'=>array());
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	
	function API_Vacation_place(){
		
              if($this->postdata){				  
				$request        = json_decode($this->postdata);			
				$member_id = $request->id; 
				$memberMoreData['vacation_place'] = $request->vacation_place;
				$result = $this->ModelApi->doSaveLifestyleData($member_id,$memberMoreData);	

				if($result){					
					$data = array('status' => true, 'message' => 'Vacation place Successfully Update','data'=>array());
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_memberblock(){
		
		
              if($this->postdata){				
				
				$request        = json_decode($this->postdata);							
				$data['from_member_id']= $request->id;
				$data['to_member_id']= $request->to_member_id;
				$data['created_date']=date('Y-m-d');
				$result = $this->ModelApi->block_member($data,$request);

				if($result){					
					$data = array('status' => true, 'message' => 'Success','data'=>array());
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_memberblocklist(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);							
				$memberId = $request->id;				
				$result = $this->ModelApi->getBlocklist($memberId);
				if($result){					
					$data = array('status' => true, 'message' => 'Block Member list','data'=>$result);
				}else{
			 $data = array('status' => false, 'message' => 'No data found','data'=>array());
			}	
	
				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_updateinterest(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);	
				
				$memberId = $request->id;
				$interest_id = explode(',',$request->interest_id);
				
				$data=array();
				if(count($interest_id) > 0){
					foreach($interest_id as $row=>$val){
						$data[$row]['interest_id']=$val;
						$data[$row]['member_id']=$memberId;
					}
			
					$result = $this->ModelApi->insert_interest($data,$memberId);
									
					if($result){					
						$data = array('status' => true, 'message' => 'Block Member list','data'=>$result);
					}else{
						$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
					}
				}else{
					$data = array('status' => false, 'message' => 'interest id is missing','data'=>array());
				}
			}else{
			$data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}			
		$this->response($data);
	}
	
	function API_interestlist(){
		
		$returnData = $this->ModelApi->getallinterest();		
		$data = array('status' => true, 'message' => 'Pet List','data'=> $returnData);
		$this->response($data);
	}
	
	function API_myprofile(){
			
              if($this->postdata){								
				$request        = json_decode($this->postdata);
			
				$memberId = $request->id;				
				$type = $request->type;				
				$result = $this->ModelApi->getmyprofile($memberId,$type);
				if($result){					
					$data = array('status' => true, 'message' => 'My profile','data'=>$result);
				}else{
					$data = array('status' => false, 'message' => 'No data found','data'=>array());	
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_memberinterest(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);							
				$memberId = $request->id;										
				$result = $this->ModelApi->getmemberinterest($memberId);
				if($result){					
					$data = array('status' => true, 'message' => 'Member interest list','data'=>$result);
				}else{
					$data = array('status' => false, 'message' => 'No data found','data'=>array());	
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_tipscategory(){
		
		$returnData = $this->ModelApi->gettipscategory();
			if($returnData){					
				$data = array('status' => true, 'message' => 'Tips Ctegory List','data'=> $returnData);
			}else{				
				$data = array('status' => false, 'message' => 'No data found','data'=>array());	
			}
		$this->response($data);
	}
	
	function API_tipssubcategory(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);							
				$id = $request->id;										
				$result = $this->ModelApi->getTipssubcategory($id);
				if($result){					
					$data = array('status' => true, 'message' => 'Tips Sub category','data'=>$result);
				}else{
					$data = array('status' => false, 'message' => 'No data found','data'=>array());	
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_myfavaourite(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);							
				$id = $request->id;
				$favarite_id = $request->favarite_id;
				
				$insert_data['member_id'] = $id;
				$insert_data['favorite_member_id'] = $favarite_id;
				$insert_data['is_delete'] = 1;
				
				$check_favarite = $this->ModelApi->checkfavarite($id,$favarite_id);
				
				//pr($check_favarite);
				
				if(empty($check_favarite))
				 {
				   $this->ModelApi->insertfavorite($insert_data);
				   $data = array('status' => true, 'message' => 'successfully Add favorite','data'=>array());
				 }else
					 {
						  if($check_favarite[0]['is_delete'] == 1)
						  {
							  //echo "0"; die;
							  $update_data['is_delete'] = 0;
							  $status ='Remove';
						  }
						  else{
							  //echo "1"; die;
							  $update_data['is_delete'] =1;
							  $status ='Add';
						  }
						  $this->ModelApi->updatefavorite($id,$favarite_id,$update_data);
						  
						  $data = array('status' => true, 'message' => 'successfully '.$status.' favorite','data'=>array());
					 }				 		
			  }
			  else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_favoritelist(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);							
				$id = $request->id;										
				$result = $this->ModelApi->getfavoritelist($id);
				if($result){					
					$data = array('status' => true, 'message' => 'Member Favorite list','data'=>$result);
				}else{
					$data = array('status' => false, 'message' => 'No data found','data'=>array());	
				}				
			  }else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	function API_counselorbooking(){
				
              if($this->postdata){								
				$request        = json_decode($this->postdata);							
				$id = $request->id;	
				$counselor_id = $request->counselor_id;	
				$bookingdatecheck = $request->bookingdate;	
				$data1['booking_date'] = $bookingdatecheck;
				
				$data1['member_id']              = $id;
				$data1['counselor_id'] = $counselor_id;
				
				$result = $this->ModelApi->bookingcheck($id,$counselor_id,$bookingdatecheck);
				
				 if($result){
					 
					$data = array('status' => true, 'message' => 'You already booked this counselor','data'=>array());
				}
				else{
					
					 $result = $this->ModelApi->booking_counselor($data1);
					 
					$data = array('status' => true, 'message' => 'Successfully Booked counselor','data'=>array());	
				}
				
			  }else{
				  
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
			}			
			$this->response($data);
	}
	
	
	function API_subscription(){
				
      if($this->postdata){				  
		$request        = json_decode($this->postdata);							
		
		 $memberId = $request->id;
		 $name       = $request->name;
		 $email_id   = $request->email_id;
		 $planId = $request->planId;
		 
		 $getPlanDetails = $this->functions->getTableData('membership_plan',array('plan_id'=>$planId));
		
		  switch($getPlanDetails[0]['plantype']){
			case '3 Months':
						$payAmt = $getPlanDetails[0]['price'];
						$billingCycle = 3;
							break;
			case '6 Months':
						$payAmt = $getPlanDetails[0]['price'];
						$billingCycle = 6;
							break;
			case '12 Months':
						$payAmt = $getPlanDetails[0]['price'];
						$billingCycle = 12;
							break;
		}
			$ccNbr          = $request->ccNbr;
			$cvv            = $request->cvv;
			$expiryMonth    = $request->expiryMonth;
			$expiryYear     = $request->expiryYear;
			//$nameOnCard     = explode(' ',$request->nameOnCard);
			$nameOnCard     = $request->nameOnCard;

			/* echo $ccNbr."<br>";
			echo $cvv."<br>";
			echo $expiryMonth."<br>";
			echo $expiryYear."<br>";
			echo $nameOnCard."<br>"; die; */
			
			
			$cardtype           = "unknown";
			$mastercardregex    = "/^5[1-5]/";
			$visacardregex      = "/^4/";
			$amexcardregex      = "/^3[47]/";
			if(preg_match($mastercardregex, $ccNbr))
			{
				$cardtype = 'mastercard';
			}
			else if (preg_match($visacardregex, $ccNbr))
			{
				$cardtype = "visa";
			}
			else if (preg_match($amexcardregex, $ccNbr))
			{
				$cardtype = "amex";
			}
			
			$first_name = $nameOnCard;
			
			$DaysTimestamp = strtotime('now');
			
			
			
			$Mo = date('m', $DaysTimestamp);
			$Day = date('d', $DaysTimestamp);
			$Year = date('Y', $DaysTimestamp);
			$StartDateGMT = $Year . '-' . $Mo . '-' . $Day . 'T00:00:00\Z';
			
			//echo $StartDateGMT; die;
			
			$request_params = array
			(
				'METHOD' => 'CreateRecurringPaymentsProfile',
				'USER' => $this->config->item('api_username'),
				'PWD' => $this->config->item('api_password'),
				'SIGNATURE' => $this->config->item('api_signature'),
				'VERSION' => $this->config->item('api_version'),
				'PAYMENTACTION' => 'Sale',
				'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
				'CREDITCARDTYPE' => $cardtype,
				'ACCT' => $ccNbr,
				'EXPDATE' => $expiryMonth.$expiryYear,
				'CVV2' => $cvv,
				'FIRSTNAME' => $first_name,
				'MIDDLENAME' => '',
				'LASTNAME' =>'',
				//'STREET' => $location,
				//'CITY' => 'Largo',
				//'STATE' => 'FL',
				//'COUNTRYCODE' => 'US',
				//'ZIP' => '33770',
				//'PHONENUMBER'=>$phone_no,
				'EMAIL'=>$email_id,
				'AMT' => $payAmt,
				'CURRENCYCODE' => 'USD',
				'DESC' => 'My Missing Rib Membership Payment',
				'BILLINGPERIOD' => 'Month',
				'BILLINGFREQUENCY' => '1',
				'TOTALBILLINGCYCLES'=>$billingCycle,
				'PROFILESTARTDATE' => $StartDateGMT,
				'MAXFAILEDPAYMENTS' => '3'
			);
			$nvp_string = '';
			foreach($request_params as $var=>$val)
			{
				$nvp_string .= '&'.$var.'='.urlencode($val);
			}//jbb
			// Send NVP string to PayPal and store response
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_URL, $this->config->item('api_endpoint'));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

			$result = curl_exec($curl);
			curl_close($curl);

			// Parse the API response
			$result_array = $this->NVPToArray($result);
						
			//pr($result_array);
			
			if(count($result_array)>0 && $result_array['ACK']=='Success'){
				$memberPayDetails['member_id']                  = $memberId;
				$memberPayDetails['name']                       = $name;
				$memberPayDetails['email']                      = $email_id;
				$memberPayDetails['plan_id']                    = $planId;
				$memberPayDetails['amount']                     = $payAmt;
				$memberPayDetails['txn_id']                     = $result_array['PROFILEID'];
				$memberPayDetails['date_payment']               = date('Y-m-d');
				$memberPayDetails['is_active']                  = 1;
				$memberPayDetails['minute_remaning']            = $getPlanDetails[0]['minute'];
				$memberPayDetails['tips_reads_remaning']        = $getPlanDetails[0]['tips_reads'];
				$memberPayDetails['messaging_remaining']        = $getPlanDetails[0]['messaging'];
				$memberPayDetails['membership_plan_data']       = json_encode($getPlanDetails[0]);
				$memberPayDetails['expiry_date']                = date('Y-m-d',strtotime("+".$billingCycle.' Months'));
				$this->ModelApi->savePaymentData($memberPayDetails);
				$error = 0;
				$message = 'Payment Done successfully';
				$data = array('status' => true, 'message' => ''.$message.'','data'=>array());
			}else{
				$error = 1;
				$message = $result_array['L_LONGMESSAGE0']!=''?$result_array['L_LONGMESSAGE0']:'Payment failed.Please try again';
				$data = array('status' => false, 'message' => ''.$message.'','data'=>array());
			}
			
		
	  }else{
	 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
	}			
	$this->response($data);
	}
	
	
	function NVPToArray($NVPString)
    {
        $proArray = array();
        while(strlen($NVPString))
        {
            // name
            $keypos= strpos($NVPString,'=');
            $keyval = substr($NVPString,0,$keypos);
            // value
            $valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
            $valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
            // decoding the respose
            $proArray[$keyval] = urldecode($valval);
            $NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
        }
        return $proArray;
    }
	
	function API_searchfavorite(){
		
		if($this->postdata){			
			$request        = json_decode($this->postdata);
			$page       = $request->page;
			
			$result = $this->ModelApi->searchfavorite($request,$page);
			
			if($result)
			{
				$data = array('status' => true, 'message' => 'Success','data'=>$result);
			}else{
				 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
	}
	
	function API_searchtips(){
		
		if($this->postdata){			
			$request        = json_decode($this->postdata);
			$page       = $request->page;
			
			$result = $this->ModelApi->searchtips($request,$page);
			//$result['tips_image'] = file_upload_base_url().'tips_image/' .$result[0]['icon'];
			
			//pr($result);
			
			if($result)
			{
				$data = array('status' => true, 'message' => 'Success','data'=>$result);
			}else{
				 $data = array('status' => false, 'message' => 'No Record found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
		
	}
	
	function API_membershipPlan(){
		
		$membershipPlans  = $this->functions->getTableData('membership_plan',array('is_active'=>1));	
		$data = array('status' => true, 'message' => 'MemberShip Plan List','data'=> $membershipPlans);
		$this->response($data);
	}
	
	function API_uploadphoto(){	
	
        $config['image_library']    = 'GD2';
		
		//echo"<pre>";print_r($_FILES["files"]);
		
		if(count($_FILES["files"]["name"])>0)
        {
			
			//echo 1;
            $config["upload_path"] = file_upload_absolute_path().'member_photo/';
            $config["allowed_types"] = 'gif|jpg|png';
            $this->upload->initialize($config);
			$certificateData[] = array();
            for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
            {
				
              $_FILES["img"]["name"]      = time().$_FILES["files"]["name"][$count];
                $_FILES["img"]["type"]      = $_FILES["files"]["type"][$count];
                $_FILES["img"]["tmp_name"]  = $_FILES["files"]["tmp_name"][$count];
                $_FILES["img"]["error"]     = $_FILES["files"]["error"][$count];
                $_FILES["img"]["size"]      = $_FILES["files"]["size"][$count];
                if($this->upload->do_upload('img'))
                {
					
                   // $certificateData[] = $this->upload->data();
					$Imgdata1 = $this->upload->data();
					//$error = $this->upload->display_errors();
						//print_r($error);
					 unset($_REQUEST['/api/API_uploadphoto']);   
					//$result = $this->ModelApi->doSaveProfileData($_REQUEST['id'],$_REQUEST);
					
                    $certificateData[$count]['photo'] = file_upload_base_url().'member_photo/'.$Imgdata1["file_name"];
                    $certificateData[$count]['member_id'] = $_REQUEST['id'];
                }
            }
			
			//pr($certificateData);
			
			if($certificateData)
			{
				$this->ModelApi->addmemberPhoto($_REQUEST['id'],$certificateData);
				
				$data22 = array('status' => true, 'message' => 'Successfully Add','data'=>array());
			} 
        }
		
		$this->response($data22); 
	}

	function API_uploadvideo(){	
	
        
		
		//echo"<pre>";print_r($_FILES["files"]);
		
		if(count($_FILES["videos"]["name"])>0)
        {
			
			//echo 1;
            $config["upload_path"] = file_upload_absolute_path().'member_video/';
            $config["allowed_types"] = '*';
            $this->upload->initialize($config);
			$certificateData[] = array();
			//pr($_FILES);
            for($count = 0; $count<count($_FILES["videos"]["name"]); $count++)
            {
				
                $_FILES["img"]["name"]      = time().$_FILES["videos"]["name"][$count];
                $_FILES["img"]["type"]      = $_FILES["videos"]["type"][$count];
                $_FILES["img"]["tmp_name"]  = $_FILES["videos"]["tmp_name"][$count];
                $_FILES["img"]["error"]     = $_FILES["videos"]["error"][$count];
                $_FILES["img"]["size"]      = $_FILES["videos"]["size"][$count];
                if($this->upload->do_upload('img'))
                {
					
                    $Imgdata1 = $this->upload->data();
					$certificateData[$count]['video'] = file_upload_base_url().'member_video/'.$Imgdata1["file_name"];
					
                    $certificateData[$count]['member_id'] = $_REQUEST['id'];
                }
            }
			
			//pr($certificateData);
			
			if($certificateData)
			{
				$this->ModelApi->addmemberVideo($_REQUEST['id'],$certificateData);
				
				$data22 = array('status' => true, 'message' => 'Successfully Add','data'=>array());
			} 
        }
		
		$this->response($data22); 
	}
	
	
	function API_deactiveProfile(){
		
		if($this->postdata){			
			$request        = json_decode($this->postdata);
			$id       = $request->id;			
			$result = $this->ModelApi->deactiveaccount($id);			
			if($result)
			{
				$data = array('status' => true, 'message' => 'Successfully Deactive Account','data'=>$result);
			}else{
				 $data = array('status' => false, 'message' => 'Some Error ..','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
		
	}
	
	// daily matches
	
	public function daily_maches()
	{
		if($this->postdata){			
			$request        = json_decode($this->postdata);
			$id       = $request->id;
			$page       = $request->page;			
			$daity_match = $this->ModelApi->daily_matches($id,$page);	
			$recent_match = $this->ModelApi->recent_matches($id);
			$result['daity_match'] = $daity_match;
			$result['recent_match'] = $recent_match;
			if(!empty($result))
			{
				$data = array('status' => true, 'message' => 'Daily Matches','data'=>$result);
			}else{
				 $data = array('status' => false, 'message' => 'No data found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}		
		$this->response($data); 
	}
	
	public function delete_photo()
	{
			if($this->postdata){			
			$request        = json_decode($this->postdata);
			$id       = $request->photo_id;
						
			$pic_data = $this->ModelApi->photo_details($id);	
			
			if(!empty($pic_data))
			{
				$this->ModelCommon->delData('member_photo',array('id'=>$id));
				$explodepic=explode("/uploads", $pic_data[0]['photo']);
				if(isset($explodepic[1])){
                    $imgpath=file_upload_absolute_path().$explodepic[1];
                    if(is_file($imgpath)){
                       unlink($imgpath);
                    }
                }
				$data = array('status' => true, 'message' => 'Image successfully deleted','data'=>array());
			}else{
				 $data = array('status' => false, 'message' => 'Photo details not found','data'=>array());
			}			
		}else{
			 $data = array('status' => false, 'message' => 'Invalid request data','data'=>array());
		}
		$this->response($data); 
	}

	function getTimeZoneList(){
    	$timezones = array(
				'Pacific/Midway'       => "(GMT-11:00) Midway Island",
				'US/Samoa'             => "(GMT-11:00) Samoa",
				'US/Hawaii'            => "(GMT-10:00) Hawaii",
				'US/Alaska'            => "(GMT-09:00) Alaska",
				'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
				'America/Tijuana'      => "(GMT-08:00) Tijuana",
				'US/Arizona'           => "(GMT-07:00) Arizona",
				'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
				'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
				'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
				'America/Mexico_City'  => "(GMT-06:00) Mexico City",
				'America/Monterrey'    => "(GMT-06:00) Monterrey",
				'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
				'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
				'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
				'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
				'America/Bogota'       => "(GMT-05:00) Bogota",
				'America/Lima'         => "(GMT-05:00) Lima",
				'America/Caracas'      => "(GMT-04:30) Caracas",
				'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
				'America/La_Paz'       => "(GMT-04:00) La Paz",
				'America/Santiago'     => "(GMT-04:00) Santiago",
				'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
				'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
				'Greenland'            => "(GMT-03:00) Greenland",
				'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
				'Atlantic/Azores'      => "(GMT-01:00) Azores",
				'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
				'Africa/Casablanca'    => "(GMT) Casablanca",
				'Europe/Dublin'        => "(GMT) Dublin",
				'Europe/Lisbon'        => "(GMT) Lisbon",
				'Europe/London'        => "(GMT) London",
				'Africa/Monrovia'      => "(GMT) Monrovia",
				'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
				'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
				'Europe/Berlin'        => "(GMT+01:00) Berlin",
				'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
				'Europe/Brussels'      => "(GMT+01:00) Brussels",
				'Europe/Budapest'      => "(GMT+01:00) Budapest",
				'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
				'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
				'Europe/Madrid'        => "(GMT+01:00) Madrid",
				'Europe/Paris'         => "(GMT+01:00) Paris",
				'Europe/Prague'        => "(GMT+01:00) Prague",
				'Europe/Rome'          => "(GMT+01:00) Rome",
				'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
				'Europe/Skopje'        => "(GMT+01:00) Skopje",
				'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
				'Europe/Vienna'        => "(GMT+01:00) Vienna",
				'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
				'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
				'Europe/Athens'        => "(GMT+02:00) Athens",
				'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
				'Africa/Cairo'         => "(GMT+02:00) Cairo",
				'Africa/Harare'        => "(GMT+02:00) Harare",
				'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
				'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
				'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
				'Europe/Kiev'          => "(GMT+02:00) Kyiv",
				'Europe/Minsk'         => "(GMT+02:00) Minsk",
				'Europe/Riga'          => "(GMT+02:00) Riga",
				'Europe/Sofia'         => "(GMT+02:00) Sofia",
				'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
				'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
				'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
				'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
				'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
				'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
				'Europe/Moscow'        => "(GMT+03:00) Moscow",
				'Asia/Tehran'          => "(GMT+03:30) Tehran",
				'Asia/Baku'            => "(GMT+04:00) Baku",
				'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
				'Asia/Muscat'          => "(GMT+04:00) Muscat",
				'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
				'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
				'Asia/Kabul'           => "(GMT+04:30) Kabul",
				'Asia/Karachi'         => "(GMT+05:00) Karachi",
				'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
				'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
				'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
				'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
				'Asia/Almaty'          => "(GMT+06:00) Almaty",
				'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
				'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
				'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
				'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
				'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
				'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
				'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
				'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
				'Australia/Perth'      => "(GMT+08:00) Perth",
				'Asia/Singapore'       => "(GMT+08:00) Singapore",
				'Asia/Taipei'          => "(GMT+08:00) Taipei",
				'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
				'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
				'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
				'Asia/Seoul'           => "(GMT+09:00) Seoul",
				'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
				'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
				'Australia/Darwin'     => "(GMT+09:30) Darwin",
				'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
				'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
				'Australia/Canberra'   => "(GMT+10:00) Canberra",
				'Pacific/Guam'         => "(GMT+10:00) Guam",
				'Australia/Hobart'     => "(GMT+10:00) Hobart",
				'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
				'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
				'Australia/Sydney'     => "(GMT+10:00) Sydney",
				'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
				'Asia/Magadan'         => "(GMT+12:00) Magadan",
				'Pacific/Auckland'     => "(GMT+12:00) Auckland",
				'Pacific/Fiji'         => "(GMT+12:00) Fiji",
			);
		$data = array('status' => true, 'message' => 'List','data'=>$timezones);
		echo json_encode($data);
    }
}	
?>