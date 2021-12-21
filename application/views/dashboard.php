<h1>đây là dashboard</h1>
<?php 
if($this->session->userdata('UserLoginSession '))
{
    $udata = $this->session->userdata('UserLoginSession');
    echo 'Welcome'.''.$udata['name'];
}
else
{
    redirect(base_url('welcom/login'));
}
?>