<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
    <link href="<?= $theme_path; ?>/images/favicon.png" rel="shortcut icon">
    <link href="<?= $theme_path; ?>/css/style.default.css" rel="stylesheet">
    <link href="<?= $theme_path; ?>/css/morris.css" rel="stylesheet">
    <link href="<?= $theme_path; ?>/css/select2.css" rel="stylesheet" />
    <link href="<?= $theme_path; ?>/css/media_print.css" rel="stylesheet" />
    
    <link href="<?=$theme_path?>/css/style.datatables.css" rel="stylesheet">
    <link href="<?=$theme_path?>/css/dataTables.responsive.css" rel="stylesheet">
    <link href="<?=$theme_path?>/css/dataTables.bootstrap.css" rel="stylesheet">  
    
    <script src="<?= $theme_path; ?>/js/jquery-1.11.1.min.js"></script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SNEHA CREATIONS</title>
</head>
<body style="font-family:Arial, Helvetica, sans-serif;margin:0;padding:0;text-align:center;color: #444;line-height:1.5em" bgcolor="#ddd">
<table style="padding:20px 0 20px 0;margin:0 auto 0 auto" cellpadding="0" cellspacing="0"> 
<tbody>
<tr> 
<td width="0%"></td> 
<td>    
    <table style="width:100%;margin:0;border:none;padding:0" cellpadding="0" cellspacing="0">
    	<tbody>
            <tr> 
                <td> 
                    <table style="padding:0;background:#fff;text-align:left" width="100%">
                        <tbody>
                            <tr height="10"><td>&nbsp;</td></tr>
                            <tr><td> <div style="margin-bottom:20px" align="center"><img src="<?= $theme_path; ?>/images/print_logo.png" alt=""></div> </td></tr>
                            <tr valign="top"> 
                            <td> 
                                <table border="0" width="100%" cellpadding="3" cellspacing="0" style="padding:15px"> <tbody>
                                    <tr valign="top"> 
                                        <td>
                                            <?=$test;?>
                                        </td>
                                    </tr> 
                                    <tr valign="top"> 
                                        <td><h2 style="font-family:Georgia, Times New Roman, Times, serif;font-weight:300;font-size:17px;line-height:22px" align="center"> <i></i></h2> 
                                        </td>
                                    </tr>
                     </tbody>
                     
                </table>
             </td>
            </tr>
        </tbody>
    </table>   
          
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:20px;background:#ccc;"> 
    	<tbody>
            <tr valign="top"> 
            	<td width="45%" align="left"> 
                	<div style="padding:1px 0;border-bottom:1px solid #666;margin-bottom:9px;"><h3>Contacts</h3></div> 
                    <div style="font-size:13px;line-height:22px;"> Phone : <?=$company_details[0]['phone_no']?><br> Email &nbsp;: <?=$company_details[0]['email']?> </div> 
                </td> 
            	<td width="10%" align="left"> 
                	<div style="padding:1px 0;margin-left:20px;margin-bottom:9px;"><h3>&nbsp;</h3></div>
                    <div style="margin-left:20px;font-size:13px;line-height:22px;">  </div> 
                </td> 
            	<td width="45%" align="left">
                	 <div style="padding:1px 0;border-bottom:1px solid #666;margin-left:20px;margin-bottom:9px;"><h3>Address</h3></div>
                     <div style="margin-left:20px;font-size:13px;line-height:22px;"> <?=$company_details[0]['address1']?>,<br> <?=$company_details[0]['address2']?>,<br> <?=$company_details[0]['city']?>, <?=$company_details[0]['state']?>- <?=$company_details[0]['pin']?>.  </div> 
                </td> 
            </tr> 
        </tbody>
    </table>
 </td>
 </tr>
 </tbody>
 </table>
    
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:0 30px 0 30px"> <tbody><tr> <td><img src="<?= $theme_path; ?>/images/shadow.png" width="100%" height="40" alt=""></td> </tr></tbody></table> </td> <td width="0%"></td> </tr></tbody></table>
    
</body>
</html>
