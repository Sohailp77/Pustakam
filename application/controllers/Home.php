<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!empty($this->session->userdata('user_id'))) {
            $this->user_id = $this->session->userdata('user_id');
        } else { 
            $this->user_id = "";
        }

        $this->load->model("Home_model");
    }

    // Default function  
    public function index() 
    {
    	$_SESSION['menu']="home";
        $arrViewParams = array();
        $arrViewParams['page_code'] = "HM";
        $arrViewParams['map_coords']=$this->Home_model->getMapCoords();

        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        $this->load->frontend_pages('index', $arrViewParams);
    }

    public function state()
    {
    	$mid=$this->input->post("mid");

    	$state=$this->Home_model->getState($mid);

        $book=$this->Home_model->getChapterExists($mid);

    	$html="";
    	$html.="<div class='text-holder'>";
        $html.="<h3 style='padding-bottom: 10px;'>".$state->state."-".$state->language."</h3>";
        $html.="<p style='text-align:justify'>".$state->description."</p>";
        $html.="</div>";

        if(empty($book))
            $html.="<a href='#'>We are In-Progress, Please Wait or Contact +91 883-099-8242</a>";
        else
            $html.="<a href='".base_url()."standard/".$mid."/0'>Click Here to get the audioPustakam</a>";

    	$arr_return = array();
        $arr_return['product_html'] = $html;
        echo (json_encode($arr_return));
    }

    public function contact()
    {
    	$_SESSION['menu']="contact";
    	$arrViewParams = array();
        $arrViewParams['page_code'] = "CT";
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        $this->load->frontend_pages('contact', $arrViewParams);
    }

    public function contact_action()
    {
        $email="ann_raj_2000@yahoo.com";
        $subject="Enquiry on audioPustakam";
        $message="<table width='50%' border='1' cellspacing='0' cellpadding='0'>
        <tr><td width='39%'>Full Name </td><td width='2%'><strong>:</strong></td><td width='59%'>".$this->input->post('form_name')."</td></tr>
        <tr><td>Email ID </td><td><strong>:</strong></td><td>".$this->input->post('form_email')."</td></tr>
        <tr><td>Phone Number </td><td><strong>:</strong></td><td>".$this->input->post('form_phone')."</td></tr>
        <tr><td>Subject</td><td><strong>:</strong></td><td>".$this->input->post('form_subject')."</td></tr>
        <tr><td>Message</td><td><strong>:</strong></td><td>".$this->input->post('form_message')."</td></tr>
        <tr><td>Created Date </td><td><strong>:</strong></td><td>".date("Y-m-d H:i:s")."</td></tr>
        </table>";

        // echo $email."<br/>";
        // echo $subject."<br/>";
        // echo $message."<br/>";

        $mail=Send_mail($email, $subject, $message);

        // echo $mail."<br/>";
        // echo "sample";
        // exit;
        redirect(site_url('contact'));
    }

    public function account()
    {
    	$_SESSION['menu']="account";
    	$arrViewParams = array();
        $arrViewParams['page_code'] = "AC";

        $arrViewParams['name']=set_value('name');
        $arrViewParams['mobile']=set_value('mobile');
        $arrViewParams['email']=set_value('email');
        $arrViewParams['password']=set_value('password');
        $arrViewParams['confirm_password']=set_value('confirm_password');

        $arrViewParams['login_mail']=set_value('login_mail');
        $arrViewParams['login_password']=set_value('login_password');
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();


        $this->load->frontend_pages('account', $arrViewParams);
    }

    public function register()
    {
    	$this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|max_length[100]|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if($this->form_validation->run() == TRUE) 
        {
        	$arrInsertParams=array(
        		'email'=>$this->input->post('email'),
        		'name'=>$this->input->post('name'),
        		'mobile'=>$this->input->post('mobile'),
        		'password'=>sha1($this->input->post('password')),
        		'created_at'=>date('Y-m-d H:i:s'),
        	);

        	if($this->Home_model->insertUser($arrInsertParams))
        	{
        		$this->session->set_flashdata('alert', ['message' => 'User added successfully.', 'type' => 'success']);
  			} 
  			else 
  			{
        		$this->session->set_flashdata('alert', ['message' => 'User NOT added successfully.', 'type' => 'danger']);
      		}
      		redirect(site_url('account'));
        }
        else
        {
        	$this->account();
        }
    }

    public function login()
    {
    	$this->form_validation->set_rules('login_mail', 'E-mail', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('login_password', 'Password', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if($this->form_validation->run() == TRUE) 
        {
        	$email=$this->input->post("login_mail");
        	$password=sha1($this->input->post("login_password"));

        	$validUserData = $this->Home_model->loginUser($email, $password);

        	if(empty($validUserData))
        	{
        		$this->session->set_flashdata('alert', ['message' => 'Login failed. Please check your Email ID / password.', 'type' => 'danger']);
        		redirect(site_url('account'));
        	}
        	else
        	{
        		$sess_data[ADMIN_SESSION_NAME] = array(
                    'email' => $validUserData->email,
                    'name' => $validUserData->name,
                );

                $this->session->set_userdata($sess_data);
                return redirect()->to($_SERVER['HTTP_REFERER']);
        	}
        }
        else
        {
        	$this->account();
        }
    }

    public function logout()
    {
    	$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
				$this->session->unset_userdata($key);
		}
		$this->session->sess_destroy();
		redirect(base_url());
    }

    public function standard($mid,$cid)
    {
        $payment_data="";
        if($this->session->userdata(ADMIN_SESSION_NAME)!=null)
        {
            $email=$this->session->userdata(ADMIN_SESSION_NAME)['email'];
            $cdate=date('Y-m-d H:i:s');
            $payment_data=$this->Home_model->getPayment($email,$cdate,$mid,$cid);
        }
        $state=$this->Home_model->getState($mid);
        $class=$this->Home_model->getClass($mid);

        $chapter="";
        if($cid==0)
        {
            $chapter=$this->Home_model->getChapter($mid,$class[0]->cid);
            $cid=$class[0]->cid;
        }    
        else
        {
            $chapter=$this->Home_model->getChapter($mid,$cid);
        }

    	$_SESSION['menu']="langauge";
    	$arrViewParams = array();
        $arrViewParams['page_code'] = "ST";
        $arrViewParams['state']=$state;
        $arrViewParams['class']=$class;
        $arrViewParams['mid']=$mid;
        $arrViewParams['cid']=$cid;
        $arrViewParams['chapter']=$chapter;
        $arrViewParams['payment_data']=$payment_data;
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();
    
        $this->load->frontend_pages('standard', $arrViewParams);
    }

    public function about()
    {
    	$_SESSION['menu']="about";
    	$arrViewParams = array();
        $arrViewParams['page_code'] = "AT";
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        $this->load->frontend_pages('about', $arrViewParams);
    }

    public function chapter($cid)
    {
        $_SESSION['menu']="langauge";
        $arrViewParams = array();
        $arrViewParams['page_code'] = "CH";

        $chapter=$this->Home_model->getChapterById($cid);
        $chapter_image=$this->Home_model->getChapterImages($cid);

        $payment_data="";
        if($this->session->userdata(ADMIN_SESSION_NAME)!=null)
        {
            $email=$this->session->userdata(ADMIN_SESSION_NAME)['email'];
            $cdate=date('Y-m-d H:i:s');
            $payment_data=$this->Home_model->getPayment($email,$cdate,$chapter->mid,$chapter->class);
        }

        $arrViewParams['chapter']=$chapter;
        $arrViewParams['chapter_image']=$chapter_image;
        $arrViewParams['payment_data']=$payment_data;
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        if($chapter->payment=="Y")
        {
            if(empty($payment_data))
            {
                redirect(base_url().'standard/'.$chapter->mid.'/0');
            }
        }

        $this->load->frontend_pages('chapter', $arrViewParams);
    }


    public function tutor($passage=1)
    {
        $_SESSION['menu']="home";
        $arrViewParams = array();
        $arrViewParams['page_code'] = "AT";
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        if($passage==1)
        {
            $arrViewParams['passage']="<p>Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place. Admittedly, climate changes have occurred on our planet before. For example, there have been several ice ages or glacial periods.</p>
<p>These climatic changes, however, were different from the modern ones in that they occurred gradually and, as far as we know, naturally. The changes currently being monitored are said to be the result not of natural causes, but of human activity. Furthermore, the rate of change is becoming alarmingly rapid.</p>
<p>The major problem is that the planet appears to be warming up. According to some experts, this warming process, known as global warming, is occurring at a rate unprecedented in the last 10,000 years. The implications for the planet are very serious. Rising global temperatures could give rise to such ecological disasters as extremely high increases in the incidence of flooding and of droughts. These in turn could have a harmful effect on agriculture.</p>
<p>It is thought that this unusual warming of the Earth has been caused by so-called greenhouse gases, such as carbon dioxide, being emitted into the atmosphere by car engines and modem industrial processes, for example. Such gases not only add to the pollution of the atmosphere, but also create a greenhouse effect, by which the heat of the sun is trapped. This leads to the warming up of the planet.</p>";
            $arrViewParams['audio']="Passage 1.mp3";
            $arrViewParams['type']=1;
        }
        else if($passage==2)
        {
            $arrViewParams['passage']="<p>Bird wings have a much more complex job to do than the wings of an airplane, for in
addition to supporting the bird they must act as its engine, rowing it through the air.
Even so the wing outline of a bird conforms to the same aerodynamic principles as
those eventually discovered by people when designing airplanes, and if you know
how different kinds of aircraft perform, you can predict the flight capabilities of
similarly shaped birds.</p>
<p>Short, stubby wings enable a tanager and other forest-living to swerve and dodge at
speed through the undergrowth, just as they helped the fighter planes of the Second
World War to make tight turns and acrobatic maneuvers in a dog-fight.</p>
<p>More modern fighters achieve greater speeds by sweeping back their wings while in
flight, just as peregrines do when they go into a 130 kph dive, swooping to a kill.
Championship gliders have long, thin wings so that, having gained height in a
thermal up-current they can soar gently for hours and an albatross, the largest of
flying birds, with a similar wing shape and a span of 3 meters, can patrol the ocean
for hours in the same way without a single wing beat.</p>";
            $arrViewParams['audio']="Passage 2.mp3";
            $arrViewParams['type']=2;
        }
        else if($passage==3)
        {
            $arrViewParams['passage']="<p>Hi! my name’s Jena. One of the things I like best about school is my art class. We
have a great teacher named Mrs. Bradely. She is a wonderful artist. I love to watch
her draw and paint. She taught us how to mix paint to make just the right colors for
our paintings.</p>
<p>She plays good music while we draw and paint. We draw and paint almost every
day in class. Some days we look at pictures of other artists. It is interesting to do
this. It helps me to think of things that I want to paint or draw. We have an art
exhibit in May this year. Our work will be in one of the banks in our town.</p>
<p>We are inviting people from the community to our exhibit. Our parents are invited to
go with us. I have three paintings I am working on now. I hope one of them will be
chosen to be in the exhibit. I like having a goal to work toward.</p>";
            $arrViewParams['audio']="Passage 3.mp3";
            $arrViewParams['type']=3;
        }

        $this->load->frontend_pages('tutor',$arrViewParams);
    }

    public function checkAudio()
    {
        $record=$this->input->post('note');
        $type=$this->input->post("type");
        $string_old="";
        if($type==1)
        {
            $string_old = "Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place. Admittedly, climate changes have occurred on our planet before. For example, there have been several ice ages or glacial periods.
These climatic changes, however, were different from the modern ones in that they occurred gradually and, as far as we know, naturally. The changes currently being monitored are said to be the result not of natural causes, but of human activity. Furthermore, the rate of change is becoming alarmingly rapid.
The major problem is that the planet appears to be warming up. According to some experts, this warming process, known as global warming, is occurring at a rate unprecedented in the last 10,000 years. The implications for the planet are very serious. Rising global temperatures could give rise to such ecological disasters as extremely high increases in the incidence of flooding and of droughts. These in turn could have a harmful effect on agriculture.
It is thought that this unusual warming of the Earth has been caused by so-called greenhouse gases, such as carbon dioxide, being emitted into the atmosphere by car engines and modem industrial processes, for example. Such gases not only add to the pollution of the atmosphere, but also create a greenhouse effect, by which the heat of the sun is trapped. This leads to the warming up of the planet.
";    
        }
        else if($type==2)
        {
            $string_old = "Bird wings have a much more complex job to do than the wings of an airplane, for in
addition to supporting the bird they must act as its engine, rowing it through the air.
Even so the wing outline of a bird conforms to the same aerodynamic principles as
those eventually discovered by people when designing airplanes, and if you know
how different kinds of aircraft perform, you can predict the flight capabilities of
similarly shaped birds.
Short, stubby wings enable a tanager and other forest-living to swerve and dodge at
speed through the undergrowth, just as they helped the fighter planes of the Second
World War to make tight turns and acrobatic maneuvers in a dog-fight.
More modern fighters achieve greater speeds by sweeping back their wings while in
flight, just as peregrines do when they go into a 130 kph dive, swooping to a kill.
Championship gliders have long, thin wings so that, having gained height in a
thermal up-current they can soar gently for hours and an albatross, the largest of
flying birds, with a similar wing shape and a span of 3 meters, can patrol the ocean
for hours in the same way without a single wing beat.";
        }
        else if($type==3)
        {
            $string_old = "Hi! my name’s Jena. One of the things I like best about school is my art class.  We
have a great teacher named Mrs. Bradely.  She is a wonderful artist.  I love to watch
her draw and paint.  She taught us how to mix paint to make just the right colors for
our paintings.
She plays good music while we draw and paint.  We draw and paint almost every
day in class.  Some days we look at pictures of other artists.  It is interesting to do
this.  It helps me to think of things that I want to paint or draw.  We have an art
exhibit in May this year.  Our work will be in one of the banks in our town. 
We are inviting people from the community to our exhibit.   Our parents are invited to
go with us.  I have three paintings I am working on now.  I hope one of them will be
chosen to be in the exhibit.  I like having a goal to work toward.";
        }
        
        $string_new = $record;

        $diffline=$this->diffline(strtolower($string_old), strtolower($string_new));

        $arrViewParams=array(
            'diffline' => $diffline,
        );

        $_SESSION['menu']="home";
        $arrViewParams['page_code'] = "AT";
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        if($type==1)
        {
            $arrViewParams['passage']="<p>Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place. Admittedly, climate changes have occurred on our planet before. For example, there have been several ice ages or glacial periods.</p>
<p>These climatic changes, however, were different from the modern ones in that they occurred gradually and, as far as we know, naturally. The changes currently being monitored are said to be the result not of natural causes, but of human activity. Furthermore, the rate of change is becoming alarmingly rapid.</p>
<p>The major problem is that the planet appears to be warming up. According to some experts, this warming process, known as global warming, is occurring at a rate unprecedented in the last 10,000 years. The implications for the planet are very serious. Rising global temperatures could give rise to such ecological disasters as extremely high increases in the incidence of flooding and of droughts. These in turn could have a harmful effect on agriculture.</p>
<p>It is thought that this unusual warming of the Earth has been caused by so-called greenhouse gases, such as carbon dioxide, being emitted into the atmosphere by car engines and modem industrial processes, for example. Such gases not only add to the pollution of the atmosphere, but also create a greenhouse effect, by which the heat of the sun is trapped. This leads to the warming up of the planet.</p>";
            $arrViewParams['audio']="Passage 1.mp3";
            $arrViewParams['type']=1;
        }
        else if($type==2)
        {
            $arrViewParams['passage']="<p>Bird wings have a much more complex job to do than the wings of an airplane, for in
addition to supporting the bird they must act as its engine, rowing it through the air.
Even so the wing outline of a bird conforms to the same aerodynamic principles as
those eventually discovered by people when designing airplanes, and if you know
how different kinds of aircraft perform, you can predict the flight capabilities of
similarly shaped birds.</p>
<p>Short, stubby wings enable a tanager and other forest-living to swerve and dodge at
speed through the undergrowth, just as they helped the fighter planes of the Second
World War to make tight turns and acrobatic maneuvers in a dog-fight.</p>
<p>More modern fighters achieve greater speeds by sweeping back their wings while in
flight, just as peregrines do when they go into a 130 kph dive, swooping to a kill.
Championship gliders have long, thin wings so that, having gained height in a
thermal up-current they can soar gently for hours and an albatross, the largest of
flying birds, with a similar wing shape and a span of 3 meters, can patrol the ocean
for hours in the same way without a single wing beat.</p>";
            $arrViewParams['audio']="Passage 2.mp3";
            $arrViewParams['type']=2;
        }
        else if($type==3)
        {
            $arrViewParams['passage']="<p>Hi! my name’s Jena. One of the things I like best about school is my art class. We
have a great teacher named Mrs. Bradely. She is a wonderful artist. I love to watch
her draw and paint. She taught us how to mix paint to make just the right colors for
our paintings.</p>
<p>She plays good music while we draw and paint. We draw and paint almost every
day in class. Some days we look at pictures of other artists. It is interesting to do
this. It helps me to think of things that I want to paint or draw. We have an art
exhibit in May this year. Our work will be in one of the banks in our town.</p>
<p>We are inviting people from the community to our exhibit. Our parents are invited to
go with us. I have three paintings I am working on now. I hope one of them will be
chosen to be in the exhibit. I like having a goal to work toward.</p>";
            $arrViewParams['audio']="Passage 3.mp3";
            $arrViewParams['type']=3;
        }
        $arrViewParams['note']=$record;

        $this->load->frontend_pages('tutor',$arrViewParams);
    }

    function diffline($line1, $line2)
    {
        $diff = $this->computeDiff(str_split($line1), str_split($line2));
        $diffval = $diff['values'];
        $diffmask = $diff['mask'];

        $n = count($diffval);
        $pmc = 0;
        $result = '';
        for ($i = 0; $i < $n; $i++)
        {
            $mc = $diffmask[$i];
            if ($mc != $pmc)
            {
                switch ($pmc)
                {
                    case -1: $result .= ' </del> '; break;
                    case 1: $result .= '</ins>'; break;
                }
                switch ($mc)
                {
                    case -1: $result .= ' <del> '; break;
                    case 1: $result .= '<ins>'; break;
                }
            }
            $result .= $diffval[$i];

            $pmc = $mc;
        }
        switch ($pmc)
        {
            case -1: $result .= ' </del> '; break;
            case 1: $result .= '</ins>'; break;
        }

        return $result;
    }


    function computeDiff($from, $to)
    {
        $diffValues = array();
        $diffMask = array();

        $dm = array();
        $n1 = count($from);
        $n2 = count($to);

        for ($j = -1; $j < $n2; $j++) $dm[-1][$j] = 0;
        for ($i = -1; $i < $n1; $i++) $dm[$i][-1] = 0;
        for ($i = 0; $i < $n1; $i++)
        {
            for ($j = 0; $j < $n2; $j++)
            {
                if ($from[$i] == $to[$j])
                {
                    $ad = $dm[$i - 1][$j - 1];
                    $dm[$i][$j] = $ad + 1;
                }
                else
                {
                    $a1 = $dm[$i - 1][$j];
                    $a2 = $dm[$i][$j - 1];
                    $dm[$i][$j] = max($a1, $a2);
                }
            }
        }

        $i = $n1 - 1;
        $j = $n2 - 1;
        while (($i > -1) || ($j > -1))
        {
            if ($j > -1)
            {
                if ($dm[$i][$j - 1] == $dm[$i][$j])
                {
                    $diffValues[] = $to[$j];
                    $diffMask[] = 1;
                    $j--;  
                    continue;              
                }
            }
            if ($i > -1)
            {
                if ($dm[$i - 1][$j] == $dm[$i][$j])
                {
                    $diffValues[] = $from[$i];
                    $diffMask[] = -1;
                    $i--;
                    continue;              
                }
            }
            {
                $diffValues[] = $from[$i];
                $diffMask[] = 0;
                $i--;
                $j--;
            }
        }    

        $diffValues = array_reverse($diffValues);
        $diffMask = array_reverse($diffMask);

        return array('values' => $diffValues, 'mask' => $diffMask);
    }

    public function tutor_new($passage=1)
    {
        $_SESSION['menu']="home";
        $arrViewParams = array();
        $arrViewParams['page_code'] = "AT";
        $arrViewParams['language_menu']=$this->Home_model->getLanguageMenu();

        if($passage==1)
        {
            $arrViewParams['passage']="<p>Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place. Admittedly, climate changes have occurred on our planet before. For example, there have been several ice ages or glacial periods.</p>
<p>These climatic changes, however, were different from the modern ones in that they occurred gradually and, as far as we know, naturally. The changes currently being monitored are said to be the result not of natural causes, but of human activity. Furthermore, the rate of change is becoming alarmingly rapid.</p>
<p>The major problem is that the planet appears to be warming up. According to some experts, this warming process, known as global warming, is occurring at a rate unprecedented in the last 10,000 years. The implications for the planet are very serious. Rising global temperatures could give rise to such ecological disasters as extremely high increases in the incidence of flooding and of droughts. These in turn could have a harmful effect on agriculture.</p>
<p>It is thought that this unusual warming of the Earth has been caused by so-called greenhouse gases, such as carbon dioxide, being emitted into the atmosphere by car engines and modem industrial processes, for example. Such gases not only add to the pollution of the atmosphere, but also create a greenhouse effect, by which the heat of the sun is trapped. This leads to the warming up of the planet.</p>";
            $arrViewParams['audio']="Passage 1.mp3";
            $arrViewParams['type']=1;
            $string_old = "Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place. Admittedly, climate changes have occurred on our planet before. For example, there have been several ice ages or glacial periods.
These climatic changes, however, were different from the modern ones in that they occurred gradually and, as far as we know, naturally. The changes currently being monitored are said to be the result not of natural causes, but of human activity. Furthermore, the rate of change is becoming alarmingly rapid"; 
            $arrViewParams['passage_arr']=explode('.',$string_old);
        }

        $this->load->frontend_pages('tutor3',$arrViewParams);
    }

    public function checkDiff()
    {
        $original=$this->input->post('original');
        $record=$this->input->post('record');

        // $original="Experts in climatology and other scientists are becoming extremely concerned about the changes to our climate which are taking place";

        // $record="Experts in climatology and other scientist are becoming extremely concerned about the changes to our climate which are taking place";

        $diff = $this->htmlDiff($original, $record);

        // echo $diff;

        echo json_encode(array('diff'=>$diff));
        exit;
    }

    function htmlDiff($original,$record)
    {
        // $original="Experts in climatology and other scientists are becoming extremely concerned  about the changes to our climate which are taking place";
        // $record="Ports climatology and other scientist are becoming becoming extremely concerned in about the changes to our climate which are taking place";
        $original_arr=explode(" ",$original);
        $record_arr=explode(" ",$record);
        $result_arr=array();

        // var_dump($original_arr);
        // var_dump($record_arr);
        $k=0;
        for($i=0;$i<count($original_arr);$i++)
        {   
            for($j=$k;$j<count($record_arr);$j++)
            {
                // echo $original_arr[$i]."   ".$record_arr[$j]."<br/>";
                if(strcmp($original_arr[$i],$record_arr[$j])==0)
                {
                    $result_arr[$i]='<ins>'.$original_arr[$i].' </ins>';
                    break;
                }
                else
                {
                    $result_arr[$i]='<del>'.$original_arr[$i].' </del>';
                }
            }
        }

        // echo $original."<br/>";
        // echo $record."<br/>";

        // var_dump($result_arr);

        return implode("",$result_arr);
    }


    
}
