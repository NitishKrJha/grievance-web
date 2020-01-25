<?php //2 3 4 5 6 7 8  10 11 13 14 15 16 17 18 19 
class Member extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'member';
		$this->load->model('ModelMember');
		$this->load->model('ModelCommon');
        $this->config->load('paypal_config');	
		//error_reporting(E_All);
	}

	public function index()
	{
        redirect(base_url());
    }
	
	public function emailExist(){
		$email_id = $this->input->post('email');
		$return = $this->ModelMember->checkEmail($email_id);
		if(count($return)>0){
			$error = 1;
		}else{
			$error = 0;
		}
		echo json_encode(array('error'=>$error));
	}
    public function checkUsername(){
        $username = $this->input->post('username');
        $return = $this->ModelMember->checkUsername($username);
        if(count($return)>0){
            $error = 1;
        }else{
            $error = 0;
        }
        echo json_encode(array('error'=>$error));
    }
	function doMemberReg(){
		$return = $this->ModelMember->checkEmail($this->input->request('email'));
		if(count($return)>0){
            $this->nsession->set_userdata('errmsg','Email already exits.');
            redirect(base_url());
		}else{
			$data['member_type']		    = 1;
			$data['email'] 				    = $this->input->post('email');
			$data['man_woman']              = $this->input->post('man_woman');
            $data['maritial_status']        = $this->input->post('maritial_status');
            $data['interested_in']          = $this->input->post('interested_in');
			$data['password'] 			    = md5($this->input->post('password'));
			$data['created']			    = date('Y-m-d H:i:s');
			$data['profile_step']			= 1;
			
			$data['expire_date']			= date('Y-m-d H:i:s', strtotime($data['created']. ' + 1 days'));
			
			$insert_id 					    = $this->ModelMember->memberReg($data);
			if($insert_id){
			    $step2Link      = base_url('member/step2/'.base64_encode($insert_id));
				$to 			= $data['email'];
				$subject		= "Registration";
				// $body			= "<tr><td>Hi,</td></tr>
				// 					<tr><td>Thanks for opening an account on our platform.Please click on link to complete your profile <a href='".$step2Link."'>Click here</a> </td></tr>";

                $body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
                  <tbody>
                    <tr> 
                      <td width="260" align="left"><table width="260" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center">
                          <tbody>
                            <tr>
                              <td width="260" height="25" />
                            </tr>
                            <tr>
                              <td width="260" align="center"><div style="font-family: Arial; font-size: 18px; color: #fff; line-height: 24px; text-align: center;"> Activate your account and start looking for new dates! </div></td>
                            </tr>
                            <tr>
                              <td width="240" align="center" cellpadding="10"><a href="'.$step2Link.'" data-ajax="false" target="_blank" rel="nofollow" style="display: block; font-size: 18px; width: 240px; padding: 10px; background-color: #58abd5; line-height: 14px; text-decoration: none; text-align: center; color: #ffffff; border-radius: 2px; box-sizing: border-box; margin-top: 10px;">Activate my account</a></td>
                            </tr>
                            <tr>
                              <td width="260" align="left"><div style="font-family: Arial; font-size: 14px; color: #fff; line-height: 18px; margin: 10px auto; display: block; width: 260px;"> You can also use the above activation code to complete your registration. Just copy & paste it on the sites confirmation page. </div></td>
                            </tr>
                            <tr>
                              <td width="260" style="background-color: #fff; text-align: center; margin: 10px auto;"><div style="background-color: #58abd5; height: 10px; display: block;"></div>
                                <div style="font-family: Arial; font-size: 14px; font-weight: bold; color: #000; line-height: 18px; text-align: center; background-color: #fff; display: block; padding-top:5px;">Your login details:</div>
                                <div style="font-family: Arial; font-size: 12px; color: #000; line-height: 22px; text-align: center; background-color: #fff; display: block;">'.$to.'</div>
                                <div style="background-color: #58abd5; height: 10px; display: block; "></div>
                                <div style="background-color: #58abd5; height: 10px; display: block;"></div></td>
                            </tr>
                          </tbody>
                        </table></td>
                      <!-- column devider -->
                      <td width="15" align="center" />
                      <!-- right column -->
                      <td width="256" align="center" valign="bottom" style="line-height: 0; text-align: center;"><img width="256" border="0" alt="#" src="'.css_images_js_base_url().'images/image1.png" style="margin: 0 auto; text-align: center; vertical-align: bottom;" /></td>
                    </tr>
                  </tbody>
                </table></td>';

				$this->functions->mail_template($to,$subject,$body);
                // $this->nsession->set_userdata('succmsg','Thanks for opening an account on our platform.Please verify email to complete your account.');
                redirect(base_url('page/thanks/'.base64_encode($data['email'])));
			}else{
                $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again');
                redirect(base_url());
			}
		}
	}
    function ChangeCoverImg(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        $coverImg                = $_FILES['coverImg']['name'];
        $new_coverImg            = time().$coverImg;
        $config['upload_path'] 	 = file_upload_absolute_path().'cover_image/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 5120;
        //$config['max_width']     = 300;
        //$config['max_height']    = 200;
        $config['file_name']     = $new_coverImg;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('coverImg')) {
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }else {
			$data_upload = $this->upload->data();
			
			$file_name = $data_upload["file_name"];
			$file_name_thumb = $data_upload['raw_name'].'_thumb' . $data_upload['file_ext']; 
			$this->load->library('image_lib');
			$config_resize['image_library'] = 'gd2';	
			//$config_resize['create_thumb'] = TRUE;
			$config_resize['maintain_ratio'] = TRUE;
			$config_resize['master_dim'] = 'width';
			$config_resize['quality'] = "100%";
			$config_resize['source_image'] = file_upload_absolute_path().'cover_image/'. $data_upload["file_name"]; 
			$config['new_image'] = file_upload_absolute_path().'cover_image/' . $data_upload["file_name"];
			$config_resize['height'] = 400;
			$config_resize['width'] = 800;
			$this->image_lib->initialize($config_resize);
			$this->image_lib->resize();
			
			
            $upload_data = array('upload_data' => $this->upload->data());
        }
        if($upload_data['upload_data']['file_name']) {
            $data['cover_image'] = file_upload_base_url().'cover_image/'.$upload_data['upload_data']['file_name'];
            $this->ModelMember->doSaveProfileData($member_id,$data);
            $this->nsession->set_userdata('coverImg',$data['cover_image']);
            $this->nsession->set_userdata('succmsg', 'Cover image updated successfully.');
            redirect(base_url('member/profile'));
            return true;
        }else{
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }
    }

    function save_img($action=''){
        error_reporting(E_ALL);
        $post = isset($_POST) ? $_POST: array();
        switch($action) {
            case 'save' :
                $this->saveProfilePic();
                $this->saveProfilePicTmp();
                break;
            default:
                $this->changeProfilePic();
        }
    }

    function saveProfilePic(){
        $ndata=array();
        $ndata['picture']=base_url()."uploads/profile_pic/".$_POST['image_name'];
        $member_id=$this->nsession->userdata('member_session_id');
        $this->db->update('member',$ndata,array('id'=>$member_id));
        //echo $this->db->last_query(); die();
        return true;
    }

    /* Function to change profile picture */
    function changeProfilePic(){
        $post = isset($_POST) ? $_POST: array();
        //pr($post);
        $max_width = "500";
        $userId = isset($post['hdn_profile_id']) ? intval($post['hdn_profile_id']) : 0;
        $path = file_upload_absolute_path().'profile_pic';
        $valid_formats = array("jpg", "png", "gif", "jpeg");
        $name = $_FILES['profile_pic']['name'];
        $size = $_FILES['profile_pic']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            if(in_array($ext,$valid_formats)) {
                if($size < (1024*1024)) {
                  $actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
                  $filePath = $path .'/'.$actual_image_name; 
                  $tmp = $_FILES['profile_pic']['tmp_name']; 
                  if(move_uploaded_file($tmp, $filePath)) {
                   $width = $this->getWidth($filePath);
                   $height = $this->getHeight($filePath); //Scale the image if it is greater than the width set above
                        if ($width > $max_width){
                            $scale = $max_width/$width;
                            //$uploaded = $this->resizeImage($filePath,$width,$height,$scale, $ext);
                        } else {
                            $scale = 1;
                           // $uploaded = $this->resizeImage($filePath,$width,$height,$scale, $ext);
                        }
                        $nn=base_url('uploads/profile_pic/');
                        $nn=$nn.$actual_image_name;
                        echo "<img id='photo' file_name='".$actual_image_name."' class='' src='".$nn.'?'.time()."' class='preview'/>";
                    }
                    else{
                           echo "failed";
                    }
                }
                else{
                    echo "Image file size max 1 MB";    
                }
                
            }
            else{
                echo "Invalid file format..";    
            }
        }
        else{
            echo "Please select image..!";
        }
        exit;
    }
    /* Function to update image */
    function saveProfilePicTmp() {
        $post = isset($_POST) ? $_POST: array();
        $userId = isset($post['id']) ? intval($post['id']) : 0;
        $path ='\\images\tmp';
        $t_width = 300; // Maximum thumbnail width
        $t_height = 300; // Maximum thumbnail height
        if(isset($_POST['t']) and $_POST['t'] == "ajax") {
            extract($_POST);
            $imagePath = file_upload_absolute_path().'profile_pic/'.$_POST['image_name'];
            $ratio = ($t_width/$w1);
            $nw = ceil($w1 * $ratio);
            $nh = ceil($h1 * $ratio);
            $nimg = imagecreatetruecolor($nw,$nh);
            $im_src = imagecreatefromjpeg($imagePath);
            imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
            imagejpeg($nimg,$imagePath,90);
        }
        echo $imagePath.'?'.time();;
        exit(0);
    }
    /* Function to resize image */
    function resizeImage($image,$width,$height,$scale) {
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
            $source = imagecreatefromjpeg($image);
            break;
            case 'gif':
            $source = imagecreatefromgif($image);
            break;
            case 'png':
            $source = imagecreatefrompng($image);
            break;
            default:
            $source = false;
            break;
        }
        imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
        imagejpeg($newImage,$image,90);
        chmod($image, 0777);
        return $image;
    }
    /* Function to get image height. */
    function getHeight($image) {
        $sizes = getimagesize($image);
        $height = $sizes[1];
        return $height;
    }
    /* Function to get image width */
    function getWidth($image) {
        $sizes = getimagesize($image);
        $width = $sizes[0];
        return $width;
    }

    //New image upload with crop & resize 
    function uploadImageFile() { // Note: GD library is required for this function

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $iWidth = $iHeight = 200; // desired image result dimensions
                $iJpgQuality = 90;

                if ($_FILES) {

                    // if no errors and size less than 250kb
                    if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
                        if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

                            // new unique filename
                            $sTempFileName = file_upload_absolute_path().'profile_pic/' . md5(time().rand());

                            // move uploaded file into destination folder
                            move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

                            // change file permission to 644
                            @chmod($sTempFileName, 0644);

                            if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                                $aSize = getimagesize($sTempFileName); // try to obtain image info
                                if (!$aSize) {
                                    @unlink($sTempFileName);
                                    return;
                                }

                                // check for image type
                                switch($aSize[2]) {
                                    case IMAGETYPE_JPEG:
                                        $sExt = '.jpg';

                                        // create a new image from file 
                                        $vImg = @imagecreatefromjpeg($sTempFileName);
                                        break;
                                    /*case IMAGETYPE_GIF:
                                        $sExt = '.gif';

                                        // create a new image from file 
                                        $vImg = @imagecreatefromgif($sTempFileName);
                                        break;*/
                                    case IMAGETYPE_PNG:
                                        $sExt = '.png';

                                        // create a new image from file 
                                        $vImg = @imagecreatefrompng($sTempFileName);
                                        break;
                                    default:
                                        @unlink($sTempFileName);
                                        return;
                                }

                                // create a new true color image
                                $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );

                                // copy and resize part of an image with resampling
                                imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);

                                // define a result image filename
                                $sResultFileName = $sTempFileName . $sExt;

                                // output image to file
                                imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                                @unlink($sTempFileName);

                                return $sResultFileName;
                            }
                        }
                    }
                }
            }
        }
    function ChangeProfileImgWithResizeCrop(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        
        $sImage = basename($this->uploadImageFile());
        //echo $sImage;
        $data['picture'] = file_upload_base_url().'profile_pic/'.$sImage;
        $data['crop_profile_image'] = file_upload_base_url().'profile_pic/'.$sImage;
        $this->ModelMember->doSaveProfileData($member_id,$data);
        $this->nsession->set_userdata('profileImg',$data['picture']);
        $this->nsession->set_userdata('succmsg', 'Profile image updated successfully.');
        redirect(base_url('member/profile'));
        //return true;
    }

    function ChangeProfileImg(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
       


	 /*   $profileImg                = $_FILES['profileImg']['name'];
        $new_profileImg            = time().$profileImg;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 5120;
        //$config['max_width']     = 300;
        //$config['max_height']    = 200;
        $config['file_name']     = $new_profileImg;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('profileImg')) {
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }else {
            $upload_data = array('upload_data' => $this->upload->data());
        } */
		
		$this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		
		$memberImage             = $_FILES['profileImg']['name'];
        $fileMemberImage         = time().$memberImage;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name']     = $fileMemberImage;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('profileImg')) {
            $this->nsession->set_userdata('errmsg',$this->upload->display_errors());
            //redirect(base_url('member/step2/'.base64_encode($memberId)));
            return true;
        } else {
            $upload_data = array('upload_data' => $this->upload->data());
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
                'width' => 223,
                'height' => 247
            );
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
            $this->image_lib->clear();
			
			$file_name = $data_upload["file_name"];
			$file_name_thumb = $data_upload['raw_name'].'_thumb' . $data_upload['file_ext']; 
			$this->load->library('image_lib');
			$config_resize['image_library'] = 'gd2';	
			$config_resize['create_thumb'] = TRUE;
			$config_resize['maintain_ratio'] = TRUE;
			$config_resize['master_dim'] = 'height';
			$config_resize['quality'] = "100%";
			$config_resize['source_image'] = file_upload_absolute_path() . 'profile_pic/' . $dataSet["file_name"]; 
			//$config['new_image'] = file_upload_absolute_path() . 'profile_pic/thumb/' . $dataSet["file_name"];
			$config_resize['height'] = 64;
			$config_resize['width'] = 1;
			$this->image_lib->initialize($config_resize);
			$this->image_lib->resize();
			
			
            $Imgdata['thamble_image'] = $dataSet['file_name'];			
        }
		
		
        if($upload_data['upload_data']['file_name']) {
			$implodeData = explode('.',$upload_data['upload_data']['file_name']);
			$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
            $data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
            $data['crop_profile_image'] = file_upload_base_url().'/profile_pic/tmp/'.$thumbImgNme;
            $this->ModelMember->doSaveProfileData($member_id,$data);
            $this->nsession->set_userdata('profileImg',$data['picture']);
            $this->nsession->set_userdata('succmsg', 'Profile image updated successfully.');
            redirect(base_url('member/profile'));
            return true;
        }else{
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }
    }

   function step2()
	{
		$memberId = base64_decode($this->uri->segment(3));		
		$checkdate = $this->ModelMember->checkExpireDate($memberId);		
		if($checkdate){		
			if($memberId!=''){
				if($this->ModelMember->checkIfStep2Complate($memberId)){
					$data['controller'] = $this->controller;

					$data['succmsg'] = $this->nsession->userdata('succmsg');
					$data['errmsg'] = $this->nsession->userdata('errmsg');

					$this->nsession->set_userdata('succmsg', "");
					$this->nsession->set_userdata('errmsg', "");

					$elements = array();
					$elements['main'] = 'member/step2';
					$element_data['main'] = $data;
					$this->layout->setLayout('layout_home');
					$this->layout->multiple_view($elements,$element_data);
				}else{
					$this->nsession->set_userdata('errmsg','Please login to access your account.');
					redirect(base_url());
				}
			}else{
				redirect(base_url());
				return true;
			}
		}else{           
		   $this->nsession->set_userdata('errmsg','Your link has been expire Please connect MMR admin.');
			 redirect(base_url());
		 }			
	}
	
    function profile($memberid=0)
    {
        //echo $this->nsession->userdata('member_session_membertype'); die();
		//$this->functions->checkUser($this->controller.'/',true);
		$base_64 = $memberid . str_repeat('=', strlen($memberid) % 4);
		$member_id = base64_decode($base_64);
		
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        if($member_id==0){
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['profileView']    = 0;
            $data['memberId'] = $member_id;
        }else{
            $member_id = $member_id;
            $data['profileView'] = 1;
            $data['memberId'] = $member_id;
			$data['my_favrite'] = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$this->nsession->userdata('member_session_id'),'favorite_member_id'=>$member_id));
			
        }

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        //pr($data['memberData']);
        
        $data['memberMoreData'] = $this->ModelMember->getMemberMoreData($member_id);

		$data['memberInterest']     = $this->ModelMember->getMemberInterest($member_id);
		$data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
		$data['membervideo']     = $this->ModelMember->getMembervideo($member_id);
		
		//pr($data['membervideo']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();

        
        $element_data['header'] = $data;
        
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        if($this->nsession->userdata('member_session_id')){
            $elements['header'] = 'layout/headerInner';
            $this->layout->setLayout('layout_inner');
            $elements['main'] = 'member/profile';
        }else{
            $elements['header'] = 'layout/headerMain';
            $this->layout->setLayout('layout_home');
            $elements['main'] = 'member/profile_back';
        }
        
        $this->layout->multiple_view($elements,$element_data);
    }

    function profile_pic_upload($memberid=0)
    {
        
        $this->functions->checkUser($this->controller.'/',true);
        $base_64 = $memberid . str_repeat('=', strlen($memberid) % 4);
        $member_id = base64_decode($base_64);
        
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        if($member_id==0){
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['profileView']    = 0;
            $data['memberId'] = $member_id;
        }else{
            $member_id = $member_id;
            $data['profileView'] = 1;
            $data['memberId'] = $member_id;
            $data['my_favrite'] = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$this->nsession->userdata('member_session_id'),'favorite_member_id'=>$member_id));
            
        }

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['memberMoreData'] = $this->ModelMember->getMemberMoreData($member_id);

        $data['memberInterest']     = $this->ModelMember->getMemberInterest($member_id);
        $data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
        $data['membervideo']     = $this->ModelMember->getMembervideo($member_id);
        
        //pr($data['membervideo']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/profile_pic_upload';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    function profile1($memberid=0)
    {
        
        $this->functions->checkUser($this->controller.'/',true);
        $base_64 = $memberid . str_repeat('=', strlen($memberid) % 4);
        $member_id = base64_decode($base_64);
        
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        if($member_id==0){
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['profileView']    = 0;
            $data['memberId'] = $member_id;
        }else{
            $member_id = $member_id;
            $data['profileView'] = 1;
            $data['memberId'] = $member_id;
            $data['my_favrite'] = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$this->nsession->userdata('member_session_id'),'favorite_member_id'=>$member_id));
            
        }

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['memberMoreData'] = $this->ModelMember->getMemberMoreData($member_id);

        $data['memberInterest']     = $this->ModelMember->getMemberInterest($member_id);
        $data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
        $data['membervideo']     = $this->ModelMember->getMembervideo($member_id);
        
        //pr($data['membervideo']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/profile_td';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    function message(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        
        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
		
        $data['memberAllMessages']     = $this->ModelMember->getAllMemberMessage($member_id);
        //$data['memberAllMessages']=array();
        //pr($data['memberAllMessages']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/message';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    function getMemberAllPhoto(){
        $response=array('error'=>1,'msg'=>'No Data Found','data'=>array());
        if($this->nsession->userdata('member_session_id') && $this->input->post('member_id')){
            $member_id=$this->input->post('member_id');
            $data=$this->ModelMember->getMemberphoto($member_id);
            if(count($data) > 0){
                $response['error']=0;
                $response['msg']='No Image Available';
                $response['data']=$data;
            }
        }
        echo json_encode($response);
    }
	
    function appearance(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileData'] = $this->ModelMember->getProfileData();
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		
		//pr($data['profileMoreData']);
		
        $data['bodyTypes'] = $this->functions->getTableData('body_type',array('is_active'=>1));
        $data['hairTypes'] = $this->functions->getTableData('hair_type',array('is_active'=>1));
        $data['eyeTypes'] = $this->functions->getTableData('eye_type',array('is_active'=>1));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        // pr($data['profileData']);
		$data['allcountry']		= $this->ModelMember->getCountry();
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/appearance';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    function saveAppearanceData(){
		
        $this->functions->checkUser($this->controller.'/',true);
        $member_id          = $this->nsession->userdata('member_session_id');
        $memberData['name']   = $this->input->post('name');
        $memberData['about_me']   = $this->input->post('about_me');
        $memberMoreData['height']     = $this->input->post('height');
        $memberMoreData['height_inches']     = $this->input->post('height_inches');
        $memberMoreData['body_type']  = $this->input->post('body_type');
        $memberMoreData['hair']       = $this->input->post('hair');
        $memberMoreData['eye']        = $this->input->post('eye');
        $memberData['profile_heading']        = $this->input->post('profile_heading');
		
        $memberData['country']        = $this->input->post('country_id');
        $memberData['state']       	  = $this->input->post('state_id');
        $memberData['city']        	  = $this->input->post('city_id');
        $memberData['zip']       	  = $this->input->post('zip');
        $memberData['age']       	  = $this->input->post('age');
		$memberData['man_woman']        = $this->input->post('interest');
		
        $this->ModelMember->doSaveAppearanceData($member_id,$memberData,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Appearance data updated successfully.');
        //redirect(base_url('member/appearance'));
        redirect(base_url('member/lifestyle'));
    }

    function lifestyle(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));

		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        // pr($data['profileData']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/lifestyle';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveLifestyleData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                      = $this->nsession->userdata('member_session_id');
        $memberMoreData['smoking']      = $this->input->post('smoking');
        $memberMoreData['drinking']     = $this->input->post('drinking');
        $memberMoreData['occupation']   = $this->input->post('occupation');
        $memberMoreData['income']       = $this->input->post('income');
		
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Lifestyle data updated successfully.');
        //redirect(base_url('member/lifestyle'));
        redirect(base_url('member/relationship'));
    }
    function relationship(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/relationship';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveRelationshipData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                      = $this->nsession->userdata('member_session_id');
        $memberMoreData['have_kids']      = $this->input->post('have_kids');
        $memberMoreData['want_kids']     = $this->input->post('want_kids');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Relationship data updated successfully.');
        //redirect(base_url('member/relationship'));
        redirect(base_url('member/background'));
    }
    function background(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));

		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['ethnicityTypes'] = $this->functions->getTableData('ethnicity',array('is_active'=>1));
        $data['faithTypes']     = $this->functions->getTableData('faith',array('is_active'=>1));
        $data['languageTypes']  = $this->functions->getTableData('language',array('is_active'=>1));
        $data['countriesTypes'] = $this->functions->getTableData('countries',array());
        $data['educationTypes'] = $this->functions->getTableData('education',array('is_active'=>1));

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/background';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveBackgroundData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                      = $this->nsession->userdata('member_session_id');
        $memberMoreData['ethnicity']    = $this->input->post('ethnicity');
        $memberMoreData['faith']        = $this->input->post('faith');
        $memberMoreData['language']     = $this->input->post('language');
        $memberMoreData['country']      = $this->input->post('country');
        $memberMoreData['state']        = $this->input->post('state');
        $memberMoreData['city']         = $this->input->post('city');
        $memberMoreData['education']    = $this->input->post('education');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Background data updated successfully.');
        redirect(base_url('member/activities'));
    }
    function activities(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['indoorActivities'] = $this->functions->getTableData('indoor_activities',array('is_active'=>1));
        $data['outdoorActivities']= $this->functions->getTableData('outdoor_activities',array('is_active'=>1));


        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/activities';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveActivityData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                              = $this->nsession->userdata('member_session_id');
        $memberMoreData['indoor_activities']    = implode(',',$this->input->post('indoor_activities'));
        $memberMoreData['outdoor_activities']   = implode(',',$this->input->post('outdoor_activities'));
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Activities/Exercise data updated successfully.');
        redirect(base_url('member/pet'));
    }
    function pet(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
		
		
        $data['petDatas'] = $this->functions->getTableData('pet',array('is_active'=>1));

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/pet';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function savePetData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                              = $this->nsession->userdata('member_session_id');
        $memberMoreData['pet']    = implode(',',$this->input->post('pet'));
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Updated successfully.');
        redirect(base_url('member/zodiac'));
    }
    function zodiac(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/zodiac';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveZodiacData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                 = $this->nsession->userdata('member_session_id');
        $memberMoreData['sign']    = $this->input->post('sign');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Zodiac data updated successfully.');
        redirect(base_url('member/politics'));
    }
    function politics(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/politics';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function savePoliticsData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                          = $this->nsession->userdata('member_session_id');
        $memberMoreData['politics_view']    = $this->input->post('politics_view');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Updated successfully.');
        redirect(base_url('member/vacation'));
    }
    function vacation(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['vacationPlaceDatas'] = $this->functions->getTableData('vacation_place',array('is_active'=>1));

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/vacation';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveVacationData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                          = $this->nsession->userdata('member_session_id');
        $memberMoreData['vacation_place']    = implode(',',$this->input->post('vacation_place'));
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Vacation data updated successfully.');
        redirect(base_url('member/upload_image'));
    }
    function counselorDashboard()
    {
        $this->functions->checkUser($this->controller.'/',true);
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['main'] = 'member/counselorDashboard';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }
    function doMemberStep2(){
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
        $appcall                    = $this->input->post('appcall');
        $memberId                   = $this->input->post('memberId');
        $data['username']           = $this->input->post('username');
        $data['profile_heading'] 	= $this->input->post('profile_heading');
        $data['dob']                = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
        $data['lifestyle'] 	        = $this->input->post('lifestyle');
        $data['about_me']            = $this->input->post('about_me');
        $data['describe_looking_for'] 	= $this->input->post('describe_looking_for');
        $data['profile_step']            = 2;
        $data['success_step']            = 1;

        $memberImage             = $_FILES['file']['name'];
        $fileMemberImage         = time().$memberImage;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name']     = $fileMemberImage;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('file')) {
            if($appcall==1){
                $resdata = array('status' => false, 'message' =>$this->upload->display_errors(),'data'=>array());
            }else{
                $this->nsession->set_userdata('errmsg',$this->upload->display_errors());
                redirect(base_url('member/step2/'.base64_encode($memberId)));
                return true;
            }
        } else {
            $upload_data = array('upload_data' => $this->upload->data());
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
        if($upload_data['upload_data']['file_name']) {
            $data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
			$implodeData = explode('.',$upload_data['upload_data']['file_name']);
			$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
			$data['crop_profile_image'] = file_upload_base_url().'/profile_pic/tmp/'.$thumbImgNme;
        }else{
            if($appcall==1){
                $resdata = array('status' => false, 'message' => 'File not uploaded.Try Again','data'=>array());
            }else{
                redirect(base_url('member/step2/'.base64_encode($memberId)));
                return true;
            }
        }
        if($this->ModelMember->doSaveProfileData($memberId,$data)){
            if($appcall==1){
                $resdata = array('status' => false, 'message' =>'Account has been completed successfully.Please login to access your account.','data'=>array());
            }else{
                // $this->nsession->set_userdata('succmsg','Account has been completed successfully.Please login to access your account.');
                redirect(base_url('page/thanks'));
                return true;
            }

        }else{
            if($appcall==1){
                $resdata = array('status' => false, 'message' =>'Some server problem occur.Please try again.','data'=>array());
            }else{
                $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again.');
                redirect(base_url('member/step2/'.base64_encode($memberId)));
                return true;
            }
        }
        if($appcall==1){
            echo json_encode($resdata);
        }
    }
	function update_account(){
        $this->functions->checkUser($this->controller.'/',true);
		$member_id 			= $this->nsession->userdata('member_session_id');
		$membertype 		= $this->nsession->userdata('member_session_membertype');
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] 	= $this->input->post('last_name');
		$data['phone_no'] 	= $this->input->post('phone_no');
		$data['modified'] 	= date('Y-m-d H:i:s');
		$this->ModelMember->updateAccount($member_id,$data);
		if($membertype==1){
			$this->nsession->set_userdata('succmsg','Account has been updated successfully.');
			redirect(base_url('owner'));
			return true;
		}else{
			$this->nsession->set_userdata('succmsg','Account has been updated successfully.');
			redirect(base_url('renter'));
			return true;
		}
	}
	function update_password(){
        $this->functions->checkUser($this->controller.'/',true);
		$member_id 								= $this->nsession->userdata('member_session_id');
		$membertype 							= $this->nsession->userdata('member_session_membertype');
		$data['old_password'] 		= $this->input->post('old_password');
		$data['new_password'] 		= $this->input->post('new_password');
		$data['cfm_new_password'] = $this->input->post('cfm_new_password');
		$checkPassword = $this->ModelMember->checkOldPassword($member_id,$data);
		if($checkPassword==0){ //Invalid old password
			$this->nsession->set_userdata('errmsg', 'Invalid old password.');
			if($membertype==1){
				redirect(base_url('owner'));
				return true;
			}else{
				redirect(base_url('renter'));
				return true;
			}
		}else{ //Valid old password
		$retunCheck = $this->ModelMember->updatePassword($data,$member_id);
			if($retunCheck){
				$this->nsession->set_userdata('succmsg', 'Password updated successfully.');
				if($membertype==1){
					redirect(base_url('owner'));
					return true;
				}else{
					redirect(base_url('renter'));
					return true;
				}
			}
		}
	}
	function chang_profile_pic(){
        $this->functions->checkUser($this->controller.'/',true);
		$member_id = $this->nsession->userdata('member_session_id');
		$membertype = $this->nsession->userdata('member_session_membertype');

		$oauth_uid = $this->functions->getNameTable('member','oauth_uid','id',$member_id);

		$profile_pic = $_FILES['profile_pic']['name'];
		$new_profile_pic = time().$profile_pic;
		$config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
		$config['allowed_types'] = '*';
		//$config['max_size']      = 20480;
		//$config['max_width']     = 300;
		//$config['max_height']    = 200;
		$config['file_name']     = $new_profile_pic;
		//$this->load->library('upload', $config);

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('profile_pic')) {
			$this->nsession->set_userdata('errmsg', $this->upload->display_errors());
			if($membertype==1){
				redirect(base_url('owner'));
				return true;
			}else{
				redirect(base_url('renter'));
				return true;
			}
		}else {
			$upload_data = array('upload_data' => $this->upload->data());
		}
		if($upload_data['upload_data']['file_name']) {
			if($oauth_uid==''){
				$data['picture'] = $upload_data['upload_data']['file_name'];
			}else{
				$data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
			}
		}else{
			$data['picture'] = "";
		}
		$this->ModelMember->updateProfileImage($member_id,$data);
		$this->nsession->set_userdata('succmsg', 'Profile image updated successfully.');
		if($membertype==1){
			redirect(base_url('owner'));
			return true;
		}else{
			redirect(base_url('renter'));
			return true;
		}
	}
    function membershipplan(){
        $this->functions->checkUser($this->controller.'/',true);

        $data['controller'] = $this->controller;

        $data['succmsg']    = $this->nsession->userdata('succmsg');
        $data['errmsg']     = $this->nsession->userdata('errmsg');

        $member_id = $this->nsession->userdata('member_session_id');

        $checkIfPaymentDone = $this->ModelMember->checkIfPaymentDone($member_id);
		
        $data['membershipPlans']  = $this->functions->getTableData('membership_plan',array('is_active'=>1));
        if(count($checkIfPaymentDone)==0){
            $data['isPremiumMemmber'] = 0;
        }else{
            $data['planDetails'] = $checkIfPaymentDone;
            $data['isPremiumMemmber'] = 1;
        }

		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/membershipplan';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function membershipPlanPayment(){

        $this->functions->checkUser($this->controller.'/',true);

        $memberId = $this->nsession->userdata('member_session_id');

        $planId = base64_decode($this->uri->segment(3));

        $getPlanDetails = $this->functions->getTableData('membership_plan',array('plan_id'=>$planId));

        $data['memberInfo'] = $this->functions->getTableData('member',array('id'=>$memberId));


        if($getPlanDetails[0]['plan_id']!=''){
            $data['controller'] = $this->controller;

            $data['getPlanDetails'] = $getPlanDetails;

            $data['succmsg'] = $this->nsession->userdata('succmsg');
            $data['errmsg'] = $this->nsession->userdata('errmsg');

            $this->nsession->set_userdata('succmsg', "");
            $this->nsession->set_userdata('errmsg', "");

            $elements = array();
            $elements['header'] = 'layout/headerInner';
            $element_data['header'] = $data;
            $elements['main'] = 'member/membershipPlanPayment';
            $element_data['main'] = $data;
            $elements['footer'] = 'layout/footer';
            $element_data['footer'] = $data;
            $this->layout->setLayout('layout_inner');
            $this->layout->multiple_view($elements,$element_data);
        }else{
            redirect(base_url('member/profile'));
        }
    }

    function add_more_time(){

        $this->functions->checkUser($this->controller.'/',true);
        $memberId = $this->nsession->userdata('member_session_id');
        $data['memberInfo'] = $this->functions->getTableData('member',array('id'=>$memberId));
        $data['controller'] = $this->controller;
        $data['getPlanDetails'] = $getPlanDetails;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/add_more_time';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    function doMembershipPaymentForVideo(){

        $memberId = $this->nsession->userdata('member_session_id');
        $name       = $this->input->post('name');
        $email_id   = $this->input->post('email_id');
        $anyone_visable   = $this->input->post('anyone_visable');

        $timemin=100;

        
       
        $payAmt = 100;
        $billingCycle = 3;
        
        

        $ccNbr          = $this->input->post('ccNbr');
        $cvv            = $this->input->post('cvv');
        $expiryMonth    = $this->input->post('expiryMonth');
        $expiryYear     = $this->input->post('expiryYear');
        $nameOnCard     = explode(' ',$this->input->post('nameOnCard'));

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
        $first_name='';
        if(count($nameOnCard)==1){
            $first_name     = $nameOnCard[0];

        }else if(count($nameOnCard) ==2){

            $first_name     = $nameOnCard[0];
            $last_name      = $nameOnCard[1];

        }else if(count($nameOnCard) == 3){

            $first_name     = $nameOnCard[0];
            $middle_name    = $nameOnCard[1];
            $last_name      = $nameOnCard[2];
        }
        else
        {
             $first_name    = '';
            $middle_name    = '';
            $last_name      = '';
        }
        
        $exp_date = $expiryMonth.$expiryYear;
        $DaysTimestamp = strtotime('now');
        $Mo = date('m', $DaysTimestamp);
        $Day = date('d', $DaysTimestamp);
        $Year = date('Y', $DaysTimestamp);
        $StartDateGMT = $Year . '-' . $Mo . '-' . $Day . 'T00:00:00\Z';
        //stripe payment
         require_once APPPATH."third_party/stripe/init.php";
        // $GLOBALS["stripeCredential"] = 'sk_test_QyNHUz6qSD2aZczNP24v57De';//key for test mode
        // $GLOBALS["stripeCredential"] = 'sk_live_AEe96XNcDrO9r8cNARI9KGXq'; // key for live mode
         $GLOBALS["stripeCredential"] = 'sk_test_QyNHUz6qSD2aZczNP24v57De';
         
        \Stripe\Stripe::setApiKey($GLOBALS["stripeCredential"]);
                try{
                $result = \Stripe\Token::create(
                    array(
                        "card" => array(
                            "name" =>  $first_name,
                            "number" => $ccNbr,
                            "exp_month" => $expiryMonth,
                            "exp_year" => $expiryYear,
                            "cvc" =>$cvv 
                        )
                    )
                );
                //send invoice
            
                 $token = $result['id']; 
                }
                catch(\Stripe\Error\Card $e) { 
                  // Since it's a decline, \Stripe\Error\Card will be caught
                  $body = $e->getJsonBody();
                   $err  = $body['error']; 
                   $error = 1;
                     $message = str_replace('_',' ',$err['code']) ;
                     echo json_encode(array('error'=>$error,'message'=>$message));
                }
                  $amount = (10*100);
                 $charge=\Stripe\Charge:: create (array (
                        "amount" => $amount,
                        "currency" => "USD",
                        "card" => $token,
                        "description" => 'Test@gmail.com'
                    ));
                
        
        if( $token !='' && (isset($charge->id) && $charge->id!='')){
            $memberPayDetails['member_id']                  = $memberId;
            $memberPayDetails['name']                       = $name;
            $memberPayDetails['email']                      = $email_id;
            $memberPayDetails['amount']                     = $payAmt;
            $memberPayDetails['txn_id']                     = $charge->id;
            $memberPayDetails['date_payment']               = date('Y-m-d');
            $memberPayDetails['is_active']                  = 1;
            $memberPayDetails['minute_remaning']            = 100;
            
           
            $datafuture['future_member']                    = $anyone_visable;
            
            $this->ModelMember->savePaymentDataMinute($memberPayDetails);
            $this->ModelMember->updateCurrentMemberData($memberId,100);
            
            
            $to             = $email_id;            
            $subject        = "Successfully Subscribe";
            // $body           = "<tr><td>Hi, Member</td></tr>
            //                     <tr><td> You have successfully added 100 minute video calling in your current membership plan. </td></tr>";
            $body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
                  <tbody style="color: #fff;">
                    <tr>
                      <td colspan="3" width="600" height="10" align="left" />
                    </tr>
                    <tr style="text-align:center;">
                      <td width="13" align="left"/>
                      <td width="13" align="left"/>
                    </tr>
                    <tr><td>Hi, Member</td></tr>
                                <tr><td> You have successfully added 100 minute video calling in your current membership plan. </td></tr>
                  </tbody>
                </table></td>';                    
            $this->functions->mail_template($to,$subject,$body);
            
            $error = 0;
            $message = 'Payment Done successfully';
            $this->nsession->set_userdata('succmsg', $message);
        }else{
            $error = 1;
            $message = 'Payment failed.Please try again';
        }
       
        echo json_encode(array('error'=>$error,'message'=>$message));
    }

    function doMembershipPayment(){

        $memberId = $this->nsession->userdata('member_session_id');
        $name       = $this->input->post('name');
        $email_id   = $this->input->post('email_id');
        $anyone_visable   = $this->input->post('anyone_visable');

        $planId = $this->input->post('planId');
		
		

        $getPlanDetails = $this->functions->getTableData('membership_plan',array('plan_id'=>$planId));
       if(!empty($getPlanDetails)){
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
		
		

        $ccNbr          = $this->input->post('ccNbr');
        $cvv            = $this->input->post('cvv');
        $expiryMonth    = $this->input->post('expiryMonth');
        $expiryYear     = $this->input->post('expiryYear');
        $nameOnCard     = explode(' ',$this->input->post('nameOnCard'));

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
        $first_name='';
        if(count($nameOnCard)==1){
            $first_name 	= $nameOnCard[0];

        }else if(count($nameOnCard) ==2){

            $first_name 	= $nameOnCard[0];
            $last_name 		= $nameOnCard[1];

        }else if(count($nameOnCard) == 3){

            $first_name 	= $nameOnCard[0];
            $middle_name 	= $nameOnCard[1];
            $last_name 		= $nameOnCard[2];
        }
		else
		{
			 $first_name 	= '';
            $middle_name 	= '';
            $last_name 		= '';
		}
		
		$exp_date = $expiryMonth.$expiryYear;
        $DaysTimestamp = strtotime('now');
        $Mo = date('m', $DaysTimestamp);
        $Day = date('d', $DaysTimestamp);
        $Year = date('Y', $DaysTimestamp);
        $StartDateGMT = $Year . '-' . $Mo . '-' . $Day . 'T00:00:00\Z';
		//stripe payment
		 require_once APPPATH."third_party/stripe/init.php";
		// $GLOBALS["stripeCredential"] = 'sk_test_QyNHUz6qSD2aZczNP24v57De';//key for test mode
		// $GLOBALS["stripeCredential"] = 'sk_live_AEe96XNcDrO9r8cNARI9KGXq'; // key for live mode
		 $GLOBALS["stripeCredential"] = 'sk_test_QyNHUz6qSD2aZczNP24v57De';
		 
	   	\Stripe\Stripe::setApiKey($GLOBALS["stripeCredential"]);
				try{
				$result = \Stripe\Token::create(
					array(
						"card" => array(
							"name" =>  $first_name,
							"number" => $ccNbr,
							"exp_month" => $expiryMonth,
							"exp_year" => $expiryYear,
							"cvc" =>$cvv 
						)
					)
				);
				//send invoice
			
				 $token = $result['id']; 
				}
				catch(\Stripe\Error\Card $e) { 
				  // Since it's a decline, \Stripe\Error\Card will be caught
				  $body = $e->getJsonBody();
				   $err  = $body['error']; 
				   $error = 1;
					 $message = str_replace('_',' ',$err['code']) ;
					 echo json_encode(array('error'=>$error,'message'=>$message));
				}
				  $amount = round($getPlanDetails[0]['price'])*100;
				 $charge=\Stripe\Charge:: create (array (
						"amount" => $amount,
						"currency" => "USD",
						"card" => $token,
						"description" => 'Test@gmail.com'
					));
				
		//stripe payment
        /* $request_params = array
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
            'MIDDLENAME' => $middle_name?$middle_name:'',
            'LASTNAME' => $last_name?$last_name:'',
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
        }
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
        $result_array = $this->NVPToArray($result); */
        //pr($result_array);
        if( $token !='' && (isset($charge->id) && $charge->id!='')){
            $memberPayDetails['member_id']                  = $memberId;
            $memberPayDetails['name']                       = $name;
            $memberPayDetails['email']                      = $email_id;
            $memberPayDetails['plan_id']                    = $planId;
            $memberPayDetails['amount']                     = $payAmt;
            $memberPayDetails['txn_id']                     = $charge->id;
            $memberPayDetails['date_payment']               = date('Y-m-d');
            $memberPayDetails['is_active']                  = 1;
            $memberPayDetails['minute_remaning']            = $getPlanDetails[0]['minute'];
            $memberPayDetails['tips_reads_remaning']        = $getPlanDetails[0]['tips_reads'];
            $memberPayDetails['messaging_remaining']        = $getPlanDetails[0]['messaging'];
            $memberPayDetails['membership_plan_data']       = json_encode($getPlanDetails[0]);
            $memberPayDetails['expiry_date']                = date('Y-m-d',strtotime("+".$billingCycle.' Months'));
           
			$datafuture['future_member']				    = $anyone_visable;
			
		    $this->ModelMember->savePaymentData($memberPayDetails);
		    $this->ModelMember->updatefutureMember($memberId,$datafuture);
			
			
			$to 			= $email_id;			
			$subject		= "Successfully Subscribe";
			$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
                  <tbody style="color: #fff;">
                    <tr>
                      <td colspan="3" width="600" height="10" align="left" />
                    </tr>
                    <tr style="text-align:center;">
                      <td width="13" align="left"/>
                      <td width="13" align="left"/>
                    </tr>
                    <tr><td>Hi, Member</td></tr>
                                <tr><td> you have successfully subscribed for '.$billingCycle.' months plans. You now have access to '.base_url().' and your plan will expire on '.$memberPayDetails['expiry_date'].' </td></tr>
                  </tbody>
                </table></td>';					
			$this->functions->mail_template($to,$subject,$body);
			
            $error = 0;
            $message = 'Payment Done successfully';
            $this->nsession->set_userdata('succmsg', $message);
        }else{
            $error = 1;
            $message = 'Payment failed.Please try again';
        }
	   }
	   else{
		   $error = 1;
            $message = 'Pland details not found';
	  }
        echo json_encode(array('error'=>$error,'message'=>$message));
    }
	function cancelMembershipPlan(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id      = $this->nsession->userdata('member_session_id');
        $paymentData    = $this->ModelMember->checkIfPaymentDone($member_id);
        $request_params = array
        (
            'METHOD'    => 'ManageRecurringPaymentsProfileStatus',
            'USER' => $this->config->item('api_username'),
            'PWD' => $this->config->item('api_password'),
            'SIGNATURE' => $this->config->item('api_signature'),
            'VERSION' => $this->config->item('api_version'),
            'PROFILEID' => $paymentData['txn_id'],
            'ACTION'    => 'Cancel',
            'NOTE'      => 'My Missing Rib Member cancel payment'
        );
        $nvp_string = '';
        foreach($request_params as $var=>$val)
        {
            $nvp_string .= '&'.$var.'='.urlencode($val);
        }
        // Send NVP string to PayPal and store response
     /*    $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $this->config->item('api_endpoint'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

        $result = curl_exec($curl);
        curl_close($curl);
        $result_array = $this->NVPToArray($result);
        if(count($result_array)>0 && $result_array['ACK']=='Success'){ */
            $member_data=$this->ModelMember->getMemberData($member_id);
            $this->ModelMember->updateMembershipStatus($paymentData['id']);
            $this->nsession->set_userdata('succmsg', 'Successfully subscription plan has been cancelled.');
            //$step2Link      = base_url('member/step2/'.base64_encode($insert_id));
            $to             = $member_data['email'];
            $subject        = "Membership Plan Cancelled";
            $body1           = "<tr><td>Hi ".$member_data['username'].",</td></tr>
                                <tr><td>You have cancelled your membership paln Successfully.</td></tr>";
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
                
        /* }else{
            $this->nsession->set_userdata('errmsg', $result_array['L_LONGMESSAGE0']);
        } */
        redirect(base_url('member/membershipplan'));
        return true;
    }
	
	function counselor()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$country_id = $this->input->post('country_id');
		$state_id = $this->input->post('state_id');
		$city_id = $this->input->post('city_id');
		$zip = $this->input->post('zip');		
		//echo $country_id; die;		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/counselor/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['counselor']		= $this->ModelMember->filter_counselor($config,$start,$param,$country_id,$state_id,$city_id,$zip);
		
		$data['paidMember']     = $this->ModelMember->getCheckpaid($memberId);
		
		//pr($data['counselor']);
		$data['toType']='counselor';
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allcounselor';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
    function book($type='',$id='',$timezone=''){
        if($timezone==''){
            $timezone=($this->nsession->userdata('member_tz'))?$this->nsession->userdata('member_tz'):'us/canada';
        }else{
            $timezone=base64_decode($timezone);
        }
        //error_reporting(E_ALL);
        if($type!='' || $id!=''){
            $id=base64_decode($id);
            $data['controller'] = $this->controller;
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['memberData']     = $this->ModelMember->getMemberData($member_id);
            
            //echo"<pre>";print_r($get_eventDate);
            //$data['getEventDate'] =  $get_eventDate; 
            $data['counselor_available'] = $this->ModelMember->counselor_availability($id);
            $data['id']=$id;
            //echo $this->db->last_query(); die();
            //echo $this->functions->converToTz($date,'US/Eastern','Asia/Kolkata'); die();
            //echo $savetime; die();
            $data['succmsg']    = $this->nsession->userdata('succmsg');
            //echo $data['succmsg']; die();
            $data['errmsg']     = $this->nsession->userdata('errmsg');
            $this->nsession->set_userdata('succmsg','');
            $this->nsession->set_userdata('errmsg', "");
            //echo $this->nsession->userdata('errmsg'); die();
            $data['timezone']=$timezone;
            //pr($data['counselor_available']);
            $elements = array();
            $elements['header'] = 'layout/headerInner';
            $element_data['header'] = $data;
            $elements['main'] = 'member/appointment';
            $element_data['main'] = $data;
            $elements['footer'] = 'layout/footer';
            $element_data['footer'] = $data;
            $this->layout->setLayout('layout_inner');
            $this->layout->multiple_view($elements,$element_data);
        }else{
            $this->nsession->set_userdata('errmsg','Invalid Page Requested');
            redirect(base_url());
        }
    }

    public function booking_notification()
    {
        $this->functions->checkUser($this->controller.'/',true);
        $data['controller'] = $this->controller;
        
        $memberId = $this->nsession->userdata('member_session_id');             
        $data['succmsg']    = $this->nsession->userdata('succmsg');
        $data['errmsg']     = $this->nsession->userdata('errmsg');
        $data['memberId'] = $member_id;
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
        $data['memberData']     = $this->ModelMember->getMemberData($memberId);
        
        $data['avalabedate']     = $this->ModelMember->geMytbookedHistory($memberId);
        //echo $this->db->last_query(); die();
        //$data['myTimezone']    =$myTimezone;
        //pr($data['avalabedate']);
        
        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/booking_history';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    public function video_call_log()
    {
        $this->functions->checkUser($this->controller.'/video_call_log/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        $config['base_url']             = base_url($this->controller."/index/");

        $config['uri_segment']          = 3;
        $config['num_links']            = 10;
        $config['page_query_string']    = false;
        $config['extra_params']         = "";
        $config['extra_params']         = "";

        $this->pagination->setAdminPaginationStyle($config);
        $start = 0;

        $data['controller'] = $this->controller;

        $param['sortType']          = $this->input->request('sortType','DESC');
        $param['sortField']         = $this->input->request('sortField','video_log_id');
        $param['searchField']       = $this->input->request('searchField','');
        $param['searchString']      = $this->input->request('searchString','');
        $param['searchText']        = $this->input->request('searchText','');
        $param['searchFromDate']    = $this->input->request('searchFromDate','');
        $param['searchToDate']      = $this->input->request('searchToDate','');
        $param['searchDisplay']     = $this->input->request('searchDisplay','20');
        $param['searchAlpha']       = $this->input->request('txt_alpha','');
        $param['searchMode']        = $this->input->request('search_mode','STRING');

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['recordset']      = $this->ModelMember->getVideoCallList($config,$start,$param);
        
        $data['startRecord']    = $start;
        $data['module']         = "Video Call log";
        
        $this->pagination->initialize($config);

        $data['params']             = $this->nsession->userdata('ADMIN_TIPS');
        $data['reload_link']        = base_url($this->controller."/video_call_log/");
        $data['search_link']        = base_url($this->controller."/video_call_log/0/1/");
       
        $data['showall_link']       = base_url($this->controller."/video_call_log/0/1");
        $data['total_rows']                 = $config['total_rows'];

        $data['succmsg']    = $this->nsession->userdata('succmsg');
        $data['errmsg']     = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/video_call_log';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

    function booking_cancel(){
        if($this->input->post('id')){
            $id=$this->input->post('id');
            $this->load->model('ModelCounselor');
            $booking_detail=$this->ModelCounselor->getBookingDetails($id);
            if(count($booking_detail) > 0){

                $n_c_data['member_id']=$booking_detail['counselor_id'];
                $n_c_data['site_url']='member/booking_notification';
                $n_c_data['contents']=$booking_detail['counselor_name']." has been canceled your appointment due to some reason";
                $n_c_data['type']='booking';
                $n_c_data['created_date']=date('Y-m-d H:i:s');
                $this->ModelCommon->insertData('member_notification',$n_c_data);
                
                $to1            = $booking_detail['counselor_email'];
                $subject1       = "Booking Cancelled";
                $body1          = "<tr><td> Hi,".$booking_detail['counselor_name']." </td></tr>
                                    <tr><td> ".($booking_detail['member_name']!='')?$booking_detail['member_name']:'member'." has been canceled your appointment due to the some person reason </td></tr>";
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
                $this->functions->mail_template($to1,$subject1,$body1);
            }
            $this->db->delete('counselor_booking',array('booking_id'=>$id));
            $this->nsession->set_userdata('succmsg','You have been successfully canceled booking');
            echo 'true';
        }else{
            $this->nsession->set_userdata('errmsg','you have requested for invalid booking');
            echo 'false';
        }
        
    }

    function getCountry()
	{
	   $catId = $this->input->post('country_id');		
	   echo json_encode($this->functions->getAllTable('states','id,name','country_id',$catId));
	}
	
	function getCity()
	{
	   $catId= $this->input->post('state_id');
	   echo json_encode($this->functions->getAllTable('cities','id,name','state_id',$catId));
	}
	
	
	function search_old()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/search/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['member']		= $this->ModelMember->getmemberList($config,$start,$param,$memberId);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function filter_member()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/search/");
		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";
		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;
		$data['controller'] = $this->controller;
		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		
		$param['country_id'] 		    = $this->input->request('country_id','');
        $param['state_id'] 	    = $this->input->request('state_id','');
        $param['city_id'] 	= $this->input->request('city_id','');
        $param['zip'] 	= $this->input->request('zip','');
        $param['loking_for'] 	= $this->input->request('loking_for','');
        $param['age_from'] 	= $this->input->request('age_from','');
        $param['age_to'] 	= $this->input->request('age_to','');
		
        $param['education'] 	= $this->input->request('education','');
        $param['language'] 	= $this->input->request('language','');
        $param['have_kids'] 	= $this->input->request('have_kids','');
        $param['smoking'] 	= $this->input->request('smoking','');
        $param['drinking'] 	= $this->input->request('drinking','');
        $param['height'] 	= $this->input->request('height','');
        $param['body_type'] 	= $this->input->request('body_type','');
        $param['eye'] 	= $this->input->request('eye','');
        $param['hair'] 	= $this->input->request('hair','');
		
		//echo $param['education']; die;
				
		$data['member']		= $this->ModelMember->filter_member($config,$start,$param,$memberId);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_MEMBER');
		
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function getCountryfilter()
	{
	   $catId = $this->input->post('country_id');			
	   echo json_encode($this->functions->getAllTable('states','id,name','country_id',$catId));
	}
	
	function getCityfilter()
	{
	   $catId= $this->input->post('state_id');
	   echo json_encode($this->functions->getAllTable('cities','id,name','state_id',$catId));
	}
	
	
	
	function mymatch_bk()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/mymatch/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['member']		= $this->ModelMember->getmemberList($config,$start,$param,$memberId);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/matchmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function filter_mymatch()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/filter_mymatch/");
		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";
		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;
		$data['controller'] = $this->controller;
		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		
		$param['country_id'] 		    = $this->input->request('country_id','');
        $param['state_id'] 	    = $this->input->request('state_id','');
        $param['city_id'] 	= $this->input->request('city_id','');
        $param['zip'] 	= $this->input->request('zip','');
        $param['loking_for'] 	= $this->input->request('loking_for','');
        $param['age_from'] 	= $this->input->request('age_from','');
        $param['age_to'] 	= $this->input->request('age_to','');
				
		$data['member']		= $this->ModelMember->filter_matchmember($config,$start,$param);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_MEMBER');
		
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/matchmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
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
	
	
	public function ajaxMemberSearch($currPage)
	{
		$data = $_POST;
		$matches = $this->ModelMember->get_search_result($data['search_string'],$currPage);
		echo json_encode($matches);
	}
	
	function interest()
	{
		//pr($_POST);
		
		//$this->nsession->set_userdata('succmsg', "");
       // $this->nsession->set_userdata('errmsg', "");
		
		  $member_id              = $this->nsession->userdata('member_session_id');	      
		  $data1['interest_id'] = $this->input->post('interest_chk'); 
		  
		//pr($interest_id);
		  
			$data=array();
		
             for($j = 0; $j < count($data1['interest_id']); $j++){
				 
				 $data[$j]['interest_id'] = $data1['interest_id'][$j];
				 $data[$j]['member_id'] = $member_id;
			 }
			
				$result = $this->ModelMember->insert_interest($data,$member_id);
		 if($result)
			  {
				  $this->nsession->set_userdata('succmsg','Your interest successfully Added.');
			  }
	}

    function search()
    {
        $this->functions->checkUser($this->controller.'/',true);
        
        $search = $_POST;
        $memberId = $this->nsession->userdata('member_session_id');
        $data['succmsg']    = $this->nsession->userdata('succmsg');
        $data['errmsg']     = $this->nsession->userdata('errmsg');
        $membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        //user details
        
        $where =' ';
        if(isset($search['gender']) && $search['gender']!='')
        {   
            $where .='and man_woman='.$search['gender'];
        }
        if((isset($search['from_age']) && $search['from_age']!='')&& $search['to_age']=='')
        {   
            $where .='and age ='.$search['from_age'];
        }
        if((isset($search['from_age']) && $search['from_age']!='')&& (isset($search['to_age']) && $search['to_age']!='') )
        {   
            $where .=' and age between '.$search['from_age'].' and '.$search['to_age'];
        }
        if(isset($search['country']) && $search['country']!='')
        {
            $where .=' and member.country ='.$search['country'];
        }
        if(isset($search['height']) && $search['height']!='')
        {
            $where .=' and height ="'.$search['height'].'"';
        }
        if(isset($search['height_inches']) && $search['height_inches']!='')
        {
            $where .=' and height_inches ="'.$search['height_inches'].'"';
        }
        if(isset($search['language']) && $search['language']!='')
        {
            $where .=' and member_more.language ='.$search['language'];
        }
        if(isset($search['education']) && $search['education']!='')
        {
            $where .=' and education ='.$search['education'];
        }
        if(isset($search['have_kids']) && $search['have_kids']!='')
        {
            $where .=' and have_kids ="'.$search['have_kids'].'"';
        }
        if(isset($search['smoking']) && $search['smoking']!='')
        {
            $where .=' and smoking ='.$search['smoking'];
        }
        if(isset($search['drinking']) && $search['drinking']!='')
        {
            $where .=' and drinking ='.$search['drinking'];
        }
        if(isset($search['body_type']) && $search['body_type']!='')
        {
            $where .=' and body_type ='.$search['body_type'];
        }
        if(isset($search['eye']) && $search['eye']!='')
        {
            $where .=' and eye ='.$search['eye'];
        }
        if(isset($search['hair']) && $search['hair']!='')
        {
            $where .=' and hair ='.$search['hair'];
        }
        if(isset($search['pincode']) && $search['pincode']!='')
        {
            $where .=' and zip ='.$search['pincode'];
        }
        
        $data['country'] = $this->ModelMember->get_country();
        $data['search_string'] = $where;
        
        $data['member'] = $this->ModelMember->get_mymatches($memberId,$where,0);
        $data['contacts'] = $this->ModelMember->get_top_ten_contacts($memberId); //echo"<pre>";print_r($data['contacts']);exit;
        $data['memberData']     = $this->ModelMember->getMemberData($memberId);
        $data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
        //pr($data['memship_plan']);
        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/matchmember';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer_v_chat';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }

	// my match section
	function mymatch($type='')
	{
		
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = $this->db->get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1))->result_array();

        //pr($membership_paln);
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		$where='';
		 if(isset($post['country']) && $post['country']!='')
		 {
			 $where.=' and member.country='.$post['country'];
		 }
		 if(isset($post['loking_for']) && $post['loking_for']!='')
		 {
			 $where.=' and member.man_woman='.$post['loking_for'];
		 }
		 if((isset($post['age_from']) && $post['age_from']!='')&& $post['age_to']=='' )
		{	
			$where .=' and age ='.$post['age_from'];
		}
		if((isset($post['age_from']) && $post['age_from']!='')&& (isset($post['age_to']) && $post['age_to']!='') )
		{	
			$where .=' and age between '.$post['age_from'].' and '.$post['age_to'];
		}
		$data['country'] = $this->ModelMember->get_country();
		$data['search_string'] = $where;
		
		$data['member'] = $this->ModelMember->get_mymatches($memberId,$where,0,$type);
		$data['contacts'] = $this->ModelMember->get_top_ten_contacts($memberId); //echo"<pre>";print_r($data['contacts']);exit;
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
        $data['type']=$type;
		//pr($data['member']);
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/matchmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer_v_chat';
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}


	public function ajaxMatchSearch($currPage)
	{
		$data = $_POST;
		$memberId = $this->nsession->userdata('member_session_id');
        $type=($this->input->post('type'))?$this->input->post('type'):'';
		$where = $data['search_string'];
		$matches = $this->ModelMember->get_mymatches($memberId,$where,$currPage,$type);
		echo json_encode($matches);
	}
    
	public function my_favaourite()
	{
		 $favourite_member_id = $this->input->post('member_id');
		 $memberId = $this->nsession->userdata('member_session_id');
		 $insert_data['member_id'] = $memberId;
		 $insert_data['favorite_member_id'] = $favourite_member_id;
		 $insert_data['is_delete'] = 1;
		 $already_fav = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$memberId,'favorite_member_id'=>$favourite_member_id));
		 if(empty($already_fav))
		 {
		   $this->ModelCommon->insertData('my_favorite',$insert_data);
           $contents=" has been selected as you favourite";
		 }
		 else
		 {
			  if($already_fav['is_delete'] == 1)
			  {
				  $update_data['is_delete'] = 0;
                  $contents=" has been removed you from his favourite list";
			  }
			  else{
				  $update_data['is_delete'] =1;
                  $contents=" has been selected as you favourite";
			  }
			  $this->ModelCommon->updateData('my_favorite',$update_data,array('member_id'=>$memberId,'favorite_member_id'=>$favourite_member_id));
		 }

        $memberData=$this->ModelMember->getMemberData($memberId);

        $nndata=array();
        $nndata['member_id']=$favourite_member_id;
        $nndata['site_url']="member/favourite";
        if($memberData['name']!=''){
            $nndata['contents']=$memberData['name'].$contents;
        }else{
            $nndata['contents']="One Member".$contents;
        }

        $nndata['type']="favourite";
        $nndata['created_date']=date('Y-m-d H:i:s');
        $this->ModelCommon->insertData('member_notification',$nndata);
        $this->nsession->set_userdata('succmsg','Updated Successfully');
	    echo json_encode("success");
	}
	// my match section
	function favourite($param='')
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		 $where='';
		 if(isset($post['country']) && $post['country']!='')
		 {
			 $where.=' and member.country='.$post['country'];
		 }
		 if(isset($post['loking_for']) && $post['loking_for']!='')
		 {
			 $where.=' and member.man_woman='.$post['loking_for'];
		 }
		 if((isset($post['age_from']) && $post['age_from']!='')&& $post['age_to']=='' )
		{	
			$where .=' and age ='.$post['age_from'];
		}
		if((isset($post['age_from']) && $post['age_from']!='')&& (isset($post['age_to']) && $post['age_to']!='') )
		{	
			$where .=' and age between '.$post['age_from'].' and '.$post['age_to'];
		}
		
		$data['country'] = get_where('countries');
		$data['search_string'] = $where;
		$data['member'] = $this->ModelMember->get_favaourite($memberId,$where,0);
		$data['search_string'] = $where;
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['param'] =$param;
		$data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
		
		//pr($data['member']);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/my_favorite';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
        $elements['chat'] = 'layout/chat_page';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	public function ajaxfavriteSearch($currPage)
	{
		$data = $_POST;
		$where = $data['search_string'];
		$memberId = $this->nsession->userdata('member_session_id');
		$matches = $this->ModelMember->get_favaourite($memberId,$where,$currPage);
		echo json_encode($matches);
	}
	
	public function blockmember($id)
	{
		$memberId = $this->nsession->userdata('member_session_id');
		$data['from_member_id']= $memberId;
		$data['to_member_id']= $id;
		$data['created_date']=date('Y-m-d');
		$this->ModelMember->block_member($data);
		$this->nsession->set_userdata('succmsg','Member Successfully Blocked.');
		redirect('member/mymatch');
	}

	public function getMemberDetails($member_id,$room=''){
		$userid = explode('_',$member_id);
		$userid = $userid[1];
		$userDetails = $this->ModelMember->getMemberInfo($userid);

		echo json_encode($userDetails);
		return true;
	}
	
	public function block_member_list(){
		
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		//$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		
		
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['blockData']     = $this->ModelMember->getBlocklist($memberId);
		
		//pr($data['blockData']);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/blocklist';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function unblockmember($id){
		
		$this->ModelMember->unblock_member($id);		
		$this->nsession->set_userdata('succmsg','Member Successfully unblocked.');
		redirect('member/block_member_list');
	}
	
	public function change_password()
	{		
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		 $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/changepassword';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function dochangepassword()
	{
		$this->functions->checkUser($this->controller.'/',true);
			$memberId = $this->nsession->userdata('member_session_id');
			$data['oldpassword'] = $this->input->request('oldpassword');
			$isTrue = $this->ModelMember->valideOldPassword($data);
			
			if($isTrue)
			{
				$data['new_admin_pwd'] = $this->input->request('newpassword');
				$this->ModelMember->updateAdminPass($memberId,$data);
				$this->nsession->set_userdata('succmsg',"Password Updated");
			}
			else
			{
				$this->nsession->set_userdata('errmsg',"Invalid Old Password ...");
			}
			if($this->nsession->userdata('member_session_membertype')==1){
                redirect('member/change_password');     
            }else{
                redirect('counselor/change_password');     
            }
			
	}
	
	public function accountdeactive(){
		
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		 $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/accountdeactive';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function do_deactiveaccount($id='')
	{
		$memberId = $this->nsession->userdata('member_session_id');
		$data['memberData']     = $this->ModelMember->deactiveaccount($memberId);		
		$this->nsession->set_userdata('succmsg',"Your account Successfully deactive");		
		redirect('logout');
	}
	
	public function upload_image()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['allimg']=$this->ModelCommon->getAllDatalist('member_photo',array('member_id'=>$memberId));
        $data['allvid']=$this->ModelCommon->getAllDatalist('member_video',array('member_id'=>$memberId));
        //pr($data['allvid']);
        $data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/upload_image';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function do_upload_photo(){
		
		$member_id = $this->nsession->userdata('member_session_id');
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		
		if(count($_FILES["files"]["name"])>0)
        {
			
			
            $config["upload_path"] = file_upload_absolute_path().'member_photo/';
            $config["allowed_types"] = 'gif|jpg|png';
            $this->upload->initialize($config);
            for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
            {
				
                $_FILES["img"]["name"]      = time().$_FILES["files"]["name"][$count];
                $_FILES["img"]["type"]      = $_FILES["files"]["type"][$count];
                $_FILES["img"]["tmp_name"]  = $_FILES["files"]["tmp_name"][$count];
                $_FILES["img"]["error"]     = $_FILES["files"]["error"][$count];
                $_FILES["img"]["size"]      = $_FILES["files"]["size"][$count];
                if($this->upload->do_upload('img'))
                {
					
                    //$certificateData[] = $this->upload->data();
					$Imgdata1 = $this->upload->data();
					
                    $certificateData[$count]['photo'] = file_upload_base_url().'member_photo/'.$Imgdata1["file_name"];
                    $certificateData[$count]['member_id'] = $member_id;
                }
            }
			
			//pr($certificateData);
		
			 if($certificateData)
			{
				$this->ModelMember->addmemberPhoto($certificateData);
			} 
        }
		
		$this->nsession->set_userdata('succmsg','Image Uploaded successfully.');
		redirect(base_url($this->controller."/upload_image"));	
	}
	
	
	public function do_upload_video(){
		
		$member_id = $this->nsession->userdata('member_session_id');
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		
		
		
		if(count($_FILES["videos"]["name"])>0)
        {
			
			
            $config["upload_path"] = file_upload_absolute_path().'member_video/';
            $config["allowed_types"] = '*';
            $this->upload->initialize($config);
            for($count = 0; $count<count($_FILES["videos"]["name"]); $count++)
            {
				
                $_FILES["img"]["name"]      = time().$_FILES["videos"]["name"][$count];
                $_FILES["img"]["type"]      = $_FILES["videos"]["type"][$count];
                $_FILES["img"]["tmp_name"]  = $_FILES["videos"]["tmp_name"][$count];
                $_FILES["img"]["error"]     = $_FILES["videos"]["error"][$count];
                $_FILES["img"]["size"]      = $_FILES["videos"]["size"][$count];
                if($this->upload->do_upload('img'))
                {
					
                    //$certificateData[] = $this->upload->data();
					$Imgdata1 = $this->upload->data();
					
                    $certificateData[$count]['video'] = file_upload_base_url().'member_video/'.$Imgdata1["file_name"];
                    $certificateData[$count]['member_id'] = $member_id;
                }
            }
			
			//pr($certificateData);
		
			 if($certificateData)
			{
				$this->ModelMember->addmemberVideo($certificateData);
			} 
        }
		
		$this->nsession->set_userdata('succmsg','Uploaded successfully.');
		redirect(base_url($this->controller."/upload_image"));	
	}
	
	function future_profile($memberid=0)
    {
		//$this->functions->checkUser($this->controller.'/',true);
		$base_64 = $memberid . str_repeat('=', strlen($memberid) % 4);
		$member_id = base64_decode($base_64);
		
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        if($member_id==0){
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['profileView']    = 0;
            $data['memberId'] = $member_id;
        }else{
            $member_id = $member_id;
            $data['profileView'] = 1;
            $data['memberId'] = $member_id;
			$data['my_favrite'] = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$this->nsession->userdata('member_session_id'),'favorite_member_id'=>$member_id));
			
        }

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['memberMoreData'] = $this->ModelMember->getMemberMoreData($member_id);

		$data['memberInterest']     = $this->ModelMember->getMemberInterest($member_id);
		$data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
		$data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
		
		//pr($data['cmsContent']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/profile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }

    function delphoto(){
        $response=array();
        $response['msg']="Invalid Request";
        $response['status']=1;
        if($this->input->post('id') && $this->input->post('type')){
            $id=$this->input->post('id');
            $member_id=$this->nsession->userdata('member_session_id');
            $type=$this->input->post('type');
            if($type=="photo"){
                $tblname="member_photo";
                $picData=$this->ModelCommon->getSingleData('member_photo',array('id'=>$id,'member_id'=>$member_id));
                $explodepic=explode("/uploads", $picData['photo']);
            }else{
                $tblname="member_video";
                $picData=$this->ModelCommon->getSingleData('member_video',array('id'=>$id,'member_id'=>$member_id));
                $explodepic=explode("/uploads", $picData['video']);
            }
            $result=$this->ModelCommon->delData($tblname,array('id'=>$id));
            if($result > 0){
                if(isset($explodepic[1])){
                    $imgpath=file_upload_absolute_path().$explodepic[1];
                    if(is_file($imgpath)){
                       unlink($imgpath);
                    }
                }
                $response = array('status' => 1, 'msg' => 'Deleted Successfully');
            }else{
                $response = array('status' => 0, 'message' => 'unable to delete, please try after some time');
            }
        }
        echo json_encode($response);
    }
	function dailyMatches()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		$data['maches'] = $this->ModelMember->get_daily_maches($memberId);
        $data['memberData']     = $this->ModelMember->getMemberData($memberId);
        $data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
		$data['user_id'] =  $memberId;
		//echo"<pre>";print_r($data['maches']);exit;
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/dailyMatches';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer1';
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}

	function dashboard()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
        $data['memberData']     = $this->ModelMember->getMemberData($memberId);
        $data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
		$data['maches'] = $this->ModelMember->get_daily_maches($memberId);
        //pr($data['maches']);
		$data['user_id'] =  $memberId;
        //echo"<pre>";print_r($data['maches']);exit;
        $data['pagedata']='dashboard';
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/dashboard';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer1';
        
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function get_top_ten()
	{
	  $memberId = $this->nsession->userdata('member_session_id');
	  $search_data = $this->input->post('search_text');
	  if($search_data!='')
	  {
		  $where = " and  name like '%".$search_data."%'";
	  }
	  $result = $this->ModelMember->get_top_ten_contacts($memberId, $where);
	 if(!empty($result) && count($result['result'])>0)
	 {
		 echo json_encode($result['result']);
	 }
	 else 
	 {
		 echo json_encode("no data found");
	 }
    }

    function voicenext(){
        //pr($_POST);
        //echo json_encode($_POST);exit;
        $to = 0;$from=0;
        if(isset($_POST['RoomName'])){
            $to = explode("_",$_POST['RoomName']);
            $from = $to[3];
            $to = $to[2];
        }

        $data = array(
            'to'=>$to,
            'from'=>$from,
            'RoomStatus'=>$_POST['RoomStatus'],
            'RoomSid'=>$_POST['RoomSid'],
            'RoomName'=>$_POST['RoomName'],
            'RoomDuration'=>isset($_POST['RoomDuration'])?$_POST['RoomDuration']:'',
            'SequenceNumber'=>isset($_POST['SequenceNumber'])?$_POST['SequenceNumber']:'',
            'StatusCallbackEvent'=>isset($_POST['StatusCallbackEvent'])?$_POST['StatusCallbackEvent']:'',
            'Timestamp'=>isset($_POST['Timestamp'])?$_POST['Timestamp']:'',
            'callDetails'=>json_encode($_POST)
        );
        if(isset($_POST['ParticipantIdentity']) && ($_POST['StatusCallbackEvent']=='participant-connected' || $_POST['StatusCallbackEvent']=='participant-disconnected')){
            $userId = explode("_",$_POST['ParticipantIdentity']);
            $data['userJoin'] = $userId[1];
        }
        
        $this->db->insert('callReport',$data);
    }
	
	
}
