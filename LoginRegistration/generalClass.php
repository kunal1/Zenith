<?php

class General
{
 
    #Check if the user is logged in.
	public function logged_in () {
		return(isset($_SESSION['loginUserId'])) ? true : false;
	}
 
	#if logged in then redirect to Template
	public function logged_in_protect() {
		if ($this->logged_in() === true) 
                    {
                    
                   
			 switch ($roleId) 
                        {
                          case 1:
                          header('Location: zenithAdmin/specialOffers.php');
                          break;
                          case 2:
                          header('Location: zenithAdmin/supportTickets.php');
                          break;
                          case 3:
                          header('Location: Template.php');
                          break;
                        }
			
			exit();
		}
	}
	
	#if not logged in then redirect to index.php
	public function logged_out_protect() {
		if ($this->logged_in() === false) {
			header('Location:../website/index.php');
			exit();
		}	
	}
 
}
?>
