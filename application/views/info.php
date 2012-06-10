<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

		<ul data-role="listview" data-split-icon="arrow-r" data-split-theme="d" class="ui-listview">
            <li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="false" data-iconpos="right" data-theme="c" >
               <a href="http://www.kupoya.com"><img src="<?= image_path('icon/286-speechbubble@2x.png', '_theme_'); ?>" class="ui-li-thumb">
				<h3 class="ui-li-heading">
					<?= $this->lang->line('About');?>
				</h3>
				
                </a> 
                <a href="#"></a>
            </li>
                        <li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="false" data-iconpos="right" data-theme="c" >
               <a href="<?= site_url('/info/privacy_policy'); ?>"><img src="<?= image_path('icon/30-key@2x.png', '_theme_'); ?>" class="ui-li-thumb">
				<h3 class="ui-li-heading">
					<?= $this->lang->line('Privacy_Policy');?>
				</h3>
				
                </a> 
                <a href="#"></a>
            </li>
                        <li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="false" data-iconpos="right" data-theme="c" >
               <a href="<?= site_url('/info/terms_of_use'); ?>"><img src="<?= image_path('icon/96-book@2x.png', '_theme_'); ?>" class="ui-li-thumb">
				<h3 class="ui-li-heading">
					<?= $this->lang->line('Terms_Of_Use');?>
				</h3>
				
                </a> 
                <a href="#"></a>
            </li>
            </ul>