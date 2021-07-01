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
<body style="font-family:Arial, Helvetica, sans-serif;margin:0;padding:0;text-align:center;color: #444;line-height:1.5em" bgcolor="#fff">
<table width="100%" cellpadding="0" cellspacing="0"> 
<tbody>
<tr>  
<td>    
    <table width="100%" cellpadding="0" cellspacing="0">
    	<tbody>
            <tr> 
                <td> 
                    <table style="padding:0;background:#fff;text-align:left" width="100%">
                       <tbody>
                            
                            <tr><td> <div align="center"><img src="<?= $theme_path; ?>/images/logo.jpg" alt=""></div> </td></tr>
                            <tr valign="top"> 
                            <td> 
                                <table border="0" width="100%" cellpadding="0" cellspacing="0"> 
                                <tbody>
                                    <tr valign="top"> 
                                        <td>
                                            <?=$test;?>
                                        </td>
                                    </tr> 
                     			</tbody>
                				</table>
                             </td>
                            </tr>
                        </tbody>
                    </table>   
          
    <table width="100%" cellpadding="0" cellspacing="0" border="0"> 
    	<tbody>
            <tr valign="top"> 
            	<td width="50%" align="left"> 
                	<strong>Contacts</strong><br>
                    Phone : <?=$company_details[0]['phone_no']?><br>
                    Email &nbsp;: <?=$company_details[0]['email']?> 
                </td>             	 
            	<td width="50%" align="left">
                	 <strong>Address</strong><br>
                     <?=$company_details[0]['address1']?>, <?=$company_details[0]['address2']?>, <br>
					 <?=$company_details[0]['city']?>, <?=$company_details[0]['state']?>- <?=$company_details[0]['pin']?>.
                </td> 
            </tr> 
        </tbody>
    </table>
 </td>
 </tr>
 </tbody>
 </table>
 </td>  
 </tr></tbody></table>
    
</body>
</html>
