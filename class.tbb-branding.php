<?php

define('TBB_BRANDING_SLUG', 'tbb_branding');

require_once dirname(__FILE__) . '/class.tgm-plugin-activation.php';

class TBBBranding
{
    
    
    function __construct()
    {
        $this->init();
    }
    
    private function init()
    {
		
        add_action('tgmpa_register', array(
            $this,
            'check'
        ));
		
		
        add_action('plugins_loaded', array(
            $this,
            'initSettings'
        ), 10);
		
        add_filter('plugin_action_links_' .TBB_BRANDING_PLUGIN_BASENAME, array(
            $this,
            'addSettingsLink'
        ));
		
    }
	
	public function addSettingsLink($links){
		
        if (!class_exists('ReduxFramework')) {
            return $links;
        }else{
			$settings_link = '<a href="options-general.php?page=' . TBB_BRANDING_SLUG . '">Settings</a>'; 
			array_unshift($links, $settings_link); 
			return $links; 
        }
	}
    
    public function check()
    {
        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(
            
            // This is an example of how to include a plugin from the WordPress Plugin Repository.
            array(
                'name' => 'Redux Framework',
                'slug' => 'redux-framework',
                'required' => true
            )
            
        );
        
        $config = array( // Message to output right before the plugins table.
            'strings' => array(
                'notice_can_install_required' => __("The Blackest Box's Branding requires the following plugin: %1$s.", TBB_BRANDING_SLUG)
            )
        );
        
        tgmpa($plugins, $config);
    }
    
    public function initSettings()
    {
        if (!class_exists('ReduxFramework')) {
            return;
        }
        $this->reduxFramework = new ReduxFramework($this->getSections(), $this->getArgs());
        
        $this->handleSettings();
    }
    
    
    
    private function getArgs()
    {
        return array(
            // TYPICAL -> Change these values as you need/desire
            'opt_name' => TBB_BRANDING_SLUG, // This is where your data is stored in the database and also becomes your global variable name.
            'display_name' => __("The Blackest Box's Branding", TBB_BRANDING_SLUG), // Name that appears at the top of your panel
            'display_version' => TBB_BRANDING_VERSION, // Version that appears at the top of your panel
            'menu_type' => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
            'allow_sub_menu' => true, // Show the sections below the admin menu item or not
            'menu_title' => __('Branding', TBB_BRANDING_SLUG),
            'page_title' => __("The Blackest Box's Branding", TBB_BRANDING_SLUG),
            'admin_bar' => false, // Show the panel pages on the admin bar
            'global_variable' => '', // Set a different name for your global variable other than the opt_name
            'dev_mode' => false, // Show the time the page took to load, etc
            'customizer' => true, // Enable basic customizer support
            
            // OPTIONAL -> Give you extra features
            'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
            'page_parent' => 'options-general.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
            'menu_icon' => '', // Specify a custom URL to an icon
            'last_tab' => '', // Force your panel to always open to a specific tab (by id)
            'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
            'page_slug' => TBB_BRANDING_SLUG, // Page slug used to denote the panel
            'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
            'default_show' => false, // If true, shows the default value next to each field that is not the default value.
            'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
            'show_import_export' => true // Shows the Import/Export panel when not used as a field.
        );
    }
    
    private function getAdminBarSection()
    {
        return array(
            'icon' => 'el-icon-home-alt',
            'title' => __('Admin Bar', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'admin_wp_logo',
                    'type' => 'switch',
                    'title' => __('Admin Bar WP logo', TBB_BRANDING_SLUG),
                    'subtitle' => __('Remove the admin bar WordPress logo.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'admin_logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Admin Bar Logo', TBB_BRANDING_SLUG),
                    'compiler' => 'true',
                    //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                    'desc' => __('Choose the admin bar logo. Default is 32 x 32 pixels big.', TBB_BRANDING_SLUG),
                    'subtitle' => __('Choose the admin bar logo. Default is 32 x 32 pixels big.', TBB_BRANDING_SLUG),
                    'default' => array()
                )
            )
        );
    }
    
    private function getLoginSection()
    {
        return array(
            'icon' => 'el-icon-key',
            'title' => __('Login', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'login_logo_url',
                    'type' => 'text',
                    'title' => __('Login Logo Link URL', TBB_BRANDING_SLUG),
                    'subtitle' => __('Change the login logo link URL.', TBB_BRANDING_SLUG),
                    'default' => '',
                    'validate' => 'url'
                ),
                array(
                    'id' => 'login_logo',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Login Logo', TBB_BRANDING_SLUG),
                    'compiler' => 'true',
                    //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                    'desc' => __('Other sizes can get configured with CSS below.', TBB_BRANDING_SLUG),
                    'subtitle' => __('Choose the backend login logo. Default is 80 x 80 pixels big.', TBB_BRANDING_SLUG),
                    'default' => array()
                    //'hint'      => array(
                    //    'title'     => 'Hint Title',
                    //    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
                    //)
                ),
                array(
                    'id' => 'login_css',
                    'type' => 'ace_editor',
                    'title' => __('Login Screen CSS', TBB_BRANDING_SLUG),
                    'subtitle' => __('Paste your login screen CSS here.', TBB_BRANDING_SLUG),
                    'mode' => 'css',
                    'theme' => 'monokai',
                    'desc' => __('Paste your login screen CSS here.', TBB_BRANDING_SLUG)
                )
            )
        );
    }
    
    private function getFooterSection()
    {
        return array(
            'icon' => 'el-icon-hand-down',
            'title' => __('Footer', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'admin_footer_version',
                    'type' => 'switch',
                    'title' => __('Remove WP Version', TBB_BRANDING_SLUG),
                    'subtitle' => __('Remove the footer WordPress version.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'admin_footer_text',
                    'type' => 'editor',
                    'title' => __('Admin Footer Text', TBB_BRANDING_SLUG),
                    'subtitle' => __('Change the admin area footer text.', TBB_BRANDING_SLUG),
                    'default' => ''
				)
          
            )
        );
    }
    
    private function getDashboardSection()
    {
        return array(
            'icon' => 'el-icon-graph',
            'title' => __('Dashboard', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'dashboard_widgets',
                    'type' => 'checkbox',
                    'title' => __('Remove Dashboard Widgets', TBB_BRANDING_SLUG),
                    'subtitle' => __('Dashboard widgets, which should be removed.', TBB_BRANDING_SLUG),
                    'desc' => __('Dashboard widgets, which should be removed.', TBB_BRANDING_SLUG),
                    
                    //Must provide key => value pairs for radio options
                    'options' => array(
                        '0' => __('Right Now Widget', TBB_BRANDING_SLUG),
                        '1' => __('Quick Press Widget', TBB_BRANDING_SLUG),
                        '2' => __('WordPress News Widget', TBB_BRANDING_SLUG),
                        '3' => __('Activity Widget', TBB_BRANDING_SLUG)
                    ),
                    'default' => array()
                ),
                array(
                    'id' => 'custom_dashboard_widget',
                    'type' => 'switch',
                    'title' => __('Custom Dashboard Widget', TBB_BRANDING_SLUG),
                    'subtitle' => __('Add a custom dashboard widget.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'custom_dashboard_widget_title',
                    'type' => 'text',
                    'required' => array(
                        'custom_dashboard_widget',
                        'equals',
                        '1'
                    ),
                    'title' => __('Widget Title', TBB_BRANDING_SLUG),
                    'subtitle' => __('Change the widget title.', TBB_BRANDING_SLUG),
                    'default' => ''
                    
                ),
                array(
                    'id' => 'custom_dashboard_widget_content',
                    'type' => 'editor',
                    'required' => array(
                        'custom_dashboard_widget',
                        'equals',
                        '1'
                    ),
                    'title' => __('Widget Content', TBB_BRANDING_SLUG),
                    'subtitle' => __('Change the widget content.', TBB_BRANDING_SLUG),
                    'default' => ''
                    
                ),
                array(
                    'id' => 'custom_dashboard_rss_widget',
                    'type' => 'switch',
                    'title' => __('Custom Dashboard RSS Widget', TBB_BRANDING_SLUG),
                    'subtitle' => __('Add a custom dashboard RSS widget.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'custom_dashboard_rss_widget_title',
                    'type' => 'text',
                    'required' => array(
                        'custom_dashboard_rss_widget',
                        'equals',
                        '1'
                    ),
                    'title' => __('RSS Widget Title', TBB_BRANDING_SLUG),
                    'subtitle' => __('Change the RSS widget title.', TBB_BRANDING_SLUG),
                    'default' => ''
                    
                ),
                array(
                    'id' => 'custom_dashboard_rss_widget_url',
                    'type' => 'text',
                    'required' => array(
                        'custom_dashboard_rss_widget',
                        'equals',
                        '1'
                    ),
                    'title' => __('RSS Widget URL', TBB_BRANDING_SLUG),
                    'subtitle' => __('Change the RSS widget URL.', TBB_BRANDING_SLUG),
                    'default' => '',
                    'validate' => 'url'
                    
                ),
                array(
                    'id' => 'custom_dashboard_rss_widget_url_items',
                    'type' => 'slider',
                    'required' => array(
                        'custom_dashboard_rss_widget',
                        'equals',
                        '1'
                    ),
                    'title' => __('RSS Widget Items', TBB_BRANDING_SLUG),
                    'subtitle' => __('Number of RSS feed items to display.', TBB_BRANDING_SLUG),
                    'desc' => __('Number of RSS feed items to display.', TBB_BRANDING_SLUG),
                    'default' => 10,
                    'min' => 1,
                    'step' => 1,
                    'max' => 50,
                    'display_value' => 'text'
                )
            )
        );
    }
    
    private function getScreenOptionsSection()
    {
        return array(
            'icon' => 'el-icon-screen',
            'title' => __('Screen Options', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'screen_options',
                    'type' => 'switch',
                    'title' => __('Screen Options', TBB_BRANDING_SLUG),
                    'subtitle' => __('Disable the WordPress screen options.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'post_metaboxes',
                    'type' => 'checkbox',
                    'title' => __('Post Metaboxes', TBB_BRANDING_SLUG),
                    'subtitle' => __('Post metaboxes, which should be removed.', TBB_BRANDING_SLUG),
                    'desc' => __('Post metaboxes, which should be removed.', TBB_BRANDING_SLUG),
                    
                    //Must provide key => value pairs for radio options
                    'options' => array(
                        'authordiv' => __('Author', TBB_BRANDING_SLUG),
                        'categorydiv' => __('Categories', TBB_BRANDING_SLUG),
                        'commentstatusdiv' => __('Discussion', TBB_BRANDING_SLUG),
                        'commentsdiv' => __('Comments', TBB_BRANDING_SLUG),
                        'formatdiv' => __('Formats', TBB_BRANDING_SLUG),
                        //'pageparentdiv' => __('Attributes', TBB_BRANDING_SLUG), 
                        'postcustom' => __('Custom fields', TBB_BRANDING_SLUG),
                        'postexcerpt' => __('Excerpt', TBB_BRANDING_SLUG),
                        //'postimagediv' => __('Featured image', TBB_BRANDING_SLUG),
                        'revisionsdiv' => __('Revisions', TBB_BRANDING_SLUG),
                        'slugdiv' => __('Slug', TBB_BRANDING_SLUG),
                        //'submitdiv' => __('Date, status, and update/save', TBB_BRANDING_SLUG),
                        'tagsdiv-post_tag' => __('Tags', TBB_BRANDING_SLUG),
                        'trackbacksdiv' => __('Trackbacks', TBB_BRANDING_SLUG)
                        
                    ),
                    'default' => array()
                ),
                array(
                    'id' => 'page_metaboxes',
                    'type' => 'checkbox',
                    'title' => __('Page Metaboxes', TBB_BRANDING_SLUG),
                    'subtitle' => __('Page metaboxes, which should be removed.', TBB_BRANDING_SLUG),
                    'desc' => __('Page metaboxes, which should be removed.', TBB_BRANDING_SLUG),
                    
                    //Must provide key => value pairs for radio options
                    'options' => array(
                        'authordiv' => __('Author', TBB_BRANDING_SLUG),
                        //'categorydiv' => __('Categories', TBB_BRANDING_SLUG),
                        'commentstatusdiv' => __('Discussion', TBB_BRANDING_SLUG),
                        'commentsdiv' => __('Comments', TBB_BRANDING_SLUG),
                        //'formatdiv' => __('Formats', TBB_BRANDING_SLUG), 
                        'pageparentdiv' => __('Attributes', TBB_BRANDING_SLUG),
                        'postcustom' => __('Custom fields', TBB_BRANDING_SLUG),
                        //'postexcerpt' => __('Excerpt', TBB_BRANDING_SLUG),
                        //'postimagediv' => __('Featured image', TBB_BRANDING_SLUG),
                        //'revisionsdiv' => __('Revisions', TBB_BRANDING_SLUG),
                        'slugdiv' => __('Slug', TBB_BRANDING_SLUG)
                        //'submitdiv' => __('Date, status, and update/save', TBB_BRANDING_SLUG),
                        //'tagsdiv-post_tag' => __('Tags', TBB_BRANDING_SLUG),
                        //'trackbacksdiv' => __('Trackbacks', TBB_BRANDING_SLUG),
                        
                    ),
                    'default' => array()
                )
                
                
            )
        );
    }
	
    private function getScriptAndStyleSection()
    {
        return array(
            'icon' => 'el-icon-file-new',
            'title' => __('Script & Style', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'admin_js',
                    'type' => 'ace_editor',
                    'title' => __('Admin Area JS', TBB_BRANDING_SLUG),
                    'subtitle' => __('Paste your admin area JS here.', TBB_BRANDING_SLUG),
                    'mode' => 'js',
                    'theme' => 'chrome',
                    'desc' => __('Paste your admin area JS here.', TBB_BRANDING_SLUG)
				),
                array(
                    'id' => 'admin_css',
                    'type' => 'ace_editor',
                    'title' => __('Admin Area CSS', TBB_BRANDING_SLUG),
                    'subtitle' => __('Paste your admin area CSS here.', TBB_BRANDING_SLUG),
                    'mode' => 'css',
                    'theme' => 'monokai',
                    'desc' => __('Paste your admin area CSS here.', TBB_BRANDING_SLUG)
						)          
            )
        );
    }
    
    private function getOtherSection()
    {
        return array(
            'icon' => 'el-icon-cogs',
            'title' => __('Other', TBB_BRANDING_SLUG),
            'fields' => array(
                array(
                    'id' => 'plugin_update_check',
                    'type' => 'switch',
                    'title' => __('Plugin Update Check', TBB_BRANDING_SLUG),
                    'subtitle' => __('Disable the WordPress plugin update check.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'help_tabs',
                    'type' => 'switch',
                    'title' => __('Help Tabs', TBB_BRANDING_SLUG),
                    'subtitle' => __('Disable the WordPress help tabs.', TBB_BRANDING_SLUG),
                    'default' => false
                ),
                array(
                    'id' => 'admin_menu_items',
                    'type' => 'checkbox',
                    'title' => __('Remove Admin Menu Items', TBB_BRANDING_SLUG),
                    'subtitle' => __('Admin menu items, which should be removed.', TBB_BRANDING_SLUG),
                    'desc' => __('Admin menu items, which should be removed.', TBB_BRANDING_SLUG),
                    //Must provide key => value pairs for radio options
                    'options' => array(
                        'index.php' => __('Dashboard', TBB_BRANDING_SLUG),
                        'edit.php' => __('Posts', TBB_BRANDING_SLUG),
                        'upload.php' => __('Media', TBB_BRANDING_SLUG),
                        'edit.php?post_type=page' => __('Pages', TBB_BRANDING_SLUG),
                        'edit-comments.php' => __('Comments', TBB_BRANDING_SLUG),
                        'themes.php' => __('Appearance', TBB_BRANDING_SLUG),
                        'plugins.php' => __('Plugins', TBB_BRANDING_SLUG),
                        'users.php' => __('Users', TBB_BRANDING_SLUG),
                        'tools.php' => __('Tools', TBB_BRANDING_SLUG),
                        'options-general.php' => __('Settings', TBB_BRANDING_SLUG)
                    ),
                    'default' => array()
                ),
				array(
                    'id' => 'default_widgets',
                    'type' => 'checkbox',
                    'title' => __('Default Widgets', TBB_BRANDING_SLUG),
                    'subtitle' => __('Default widgets, which should be removed.', TBB_BRANDING_SLUG),
                    'desc' => __('Default widgets, which should be removed.', TBB_BRANDING_SLUG),
                    
                    //Must provide key => value pairs for radio options
                    'options' => array(
						//unregister_widget('WP_Widget_Pages');
						'WP_Widget_Pages' => __('Pages', TBB_BRANDING_SLUG),
							
						//unregister_widget('WP_Widget_Calendar');
						'WP_Widget_Calendar' => __('Calendar', TBB_BRANDING_SLUG),
						
						//unregister_widget('WP_Widget_Archives');
						'WP_Widget_Archives' => __('Archives', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Links');
						'WP_Widget_Links' => __('Links', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Meta');
						'WP_Widget_Meta' => __('Meta', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Search');
						'WP_Widget_Search' => __('Search', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Text');
						'WP_Widget_Text' => __('Text', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Categories');
						'WP_Widget_Categories' => __('Categories', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Recent_Posts');
						'WP_Widget_Recent_Posts' => __('Recent Posts', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_Recent_Comments');
						'WP_Widget_Recent_Comments' => __('Recent Comments', TBB_BRANDING_SLUG),

						//unregister_widget('WP_Widget_RSS');
						'WP_Widget_RSS' => __('RSS', TBB_BRANDING_SLUG),
						
						//unregister_widget('WP_Widget_Tag_Cloud');
						'WP_Widget_Tag_Cloud' => __('Tag Cloud', TBB_BRANDING_SLUG),
						
						//unregister_widget('WP_Nav_Menu_Widget');
						'WP_Nav_Menu_Widget' => __('Nav Menu', TBB_BRANDING_SLUG),
							
                        
                    ),
                    'default' => array()
                ),
				
            )
        );
    }
    
    public function getSections()
    {
        $sections = array();
        $sections[] = $this->getAdminBarSection();
        $sections[] = $this->getLoginSection();
		$sections[] = $this->getFooterSection();
        $sections[] = $this->getDashboardSection();
		$sections[] = $this->getScreenOptionsSection();
		$sections[] = $this->getScriptAndStyleSection();
        $sections[] = $this->getOtherSection();
        
        return $sections;
    }
    
    private function handleSettings()
    {
        
        global ${TBB_BRANDING_SLUG};
        
        $this->settings = ${TBB_BRANDING_SLUG};
		
        
        if (is_admin()) {
            
            add_action('wp_dashboard_setup', array(
                $this,
                'removeDashboardWidgets'
            ));
            
            if ($this->settings['plugin_update_check']) {
                $this->disablePluginUpdateCheck();
            }
            
            add_action('admin_head', array(
                $this,
                'addAdminCSS'
            ));
			
			
            if ($this->settings['admin_js']) {
	            add_action('admin_head', array(
	                $this,
	                'addAdminJS'
	            ));
            }

            
            if ($this->settings['admin_wp_logo']) {
                add_action('admin_bar_menu', array(
                    $this,
                    'removeAdminBarLogo'
                ), 9999);
            }
            
            if ($this->settings['admin_footer_text']) {
                add_filter('admin_footer_text', array(
                    $this,
                    'filterAdminFooterText'
                ), 9999);
            }
            
            if ($this->settings['admin_footer_version']) {
                add_filter('update_footer', array(
                    $this,
                    'filterUpdateFooter'
                ), 9999);
            }
            
            add_action('admin_menu', array(
                $this,
                'removeAdminMenuItems'
            ));
            
            add_action('admin_menu', array(
                $this,
                'removeMetaboxes'
            ));
            
            if ($this->settings['custom_dashboard_widget']) {
                add_action('wp_dashboard_setup', array(
                    $this,
                    'addCustomDashboardWidget'
                ));
                
            }
            
            if ($this->settings['custom_dashboard_rss_widget']) {
                add_action('wp_dashboard_setup', array(
                    $this,
                    'addCustomDashboardRSSWidget'
                ));
                
            }
            
            if ($this->settings['help_tabs']) {
                add_action('admin_head', array(
                    $this,
                    'removeHelpTabs'
                ));
                
            }
            
            if ($this->settings['screen_options']) {
                add_filter('screen_options_show_screen', '__return_false');
                
            }
        }
        
        add_action('login_enqueue_scripts', array(
            $this,
            'addLoginCSS'
        ));
        
        if ($this->settings['login_logo_url']) {
            
            add_filter('login_headerurl', array(
                $this,
                'changeLoginHeaderURL'
            ));
        }
		
		add_action('widgets_init', array(
            $this,
            'removeDefaultWidgets'
        ), 1);
		
        
    }
    
    private function disablePluginUpdateCheck()
    {
        remove_action('load-update-core.php', 'wp_update_plugins');
        add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
    }
	
    public function removeDefaultWidgets()
    {
        $values = $this->settings['default_widgets'];
        
        if (empty($values))
            return;
        
        foreach ($values as $key => $value) {
            if ($value) {
                unregister_widget($key);
            }
            
        }
    }
    
    public function removeDashboardWidgets()
    {
        global $wp_meta_boxes;
        
        if ($this->settings['dashboard_widgets']['0'])
            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        
        if ($this->settings['dashboard_widgets']['1'])
            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        
        if ($this->settings['dashboard_widgets']['2'])
            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        
        if ($this->settings['dashboard_widgets']['3'])
            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        
        
        //update_user_meta(get_current_user_id(), 'show_welcome_panel', false);
        //
    }
    
    
    
    public function addLoginCSS()
    {
?>
       <style type="text/css">
	   <?php
        if (!empty($this->settings['login_logo']['url'])) {
?>
            body.login div#login h1 a {
                background-image: url(<?php
            echo $this->settings['login_logo']['url'];
?>);
            }
			<?php
        }
        echo $this->settings['login_css'];
?>
        </style>
    <?php
    }
	
	
    
    public function changeLoginHeaderURL($url)
    {
        return $this->settings['login_logo_url'];
    }
    
    public function removeAdminBarLogo($wp_admin_bar)
    {
        $wp_admin_bar->remove_node('wp-logo');
    }
    
    public function addAdminCSS()
    {
?>
       <style type="text/css">
	   <?php
        if (!empty($this->settings['admin_logo']['url'])) {
?>
		   

		   
            #wpadminbar #wp-admin-bar-site-name>.ab-item:before {
				content:'' !important;
				background-size: 22px;
				width: 22px;
				height: 20px;
				background-position: center center;
				background-repeat: no-repeat;
                background-image: url(<?php
            echo $this->settings['admin_logo']['url'];
?>) !important;
            }
			
 		   @media screen and (max-width: 782px){
 		   	#wpadminbar #wp-admin-bar-site-name>.ab-item:before {
				
 				background-size: 32px;
 				width: 32px;
 				height: 30px;
 			}
 		   }
			<?php
        }
        echo $this->settings['admin_css'];
?>
        </style>
    <?php
    }
	
    public function addAdminJS()
    {
?>
       <script>
	   <?php echo $this->settings['admin_js']; ?>
        </script>
    <?php
    }
    
    public function filterAdminFooterText()
    {
        return do_shortcode($this->settings['admin_footer_text']);
    }
    
    public function filterUpdateFooter()
    {
        return '';
    }
    
    public function removeAdminMenuItems()
    {
        
        $values = $this->settings['admin_menu_items'];
        
        if (empty($values))
            return;
        
        foreach ($values as $key => $value) {
            if ($value) {
                remove_menu_page($key);
            }
            
        }
    }
    
    public function removeMetaboxes()
    {
        $types = array(
            'post',
            'page'
        );
        
        foreach ($types as $type) {
            $values = $this->settings[$type . '_metaboxes'];
            
            if (empty($values))
                continue;
            
            foreach ($values as $key => $value) {
                if ($value) {
                    
                    $context = 'normal';
                    
                    switch ($key) {
                        case 'categorydiv':
                        case 'formatdiv':
                        case 'pageparentdiv':
                        case 'postimagediv':
                        case 'tagsdiv-post_tag':
                            $context = 'side';
                            break;
                    }
                    remove_meta_box($key, $type, $context);
                    
                }
                
            }
        }
        
    }
    
    public function addCustomDashboardWidget()
    {
        wp_add_dashboard_widget(TBB_BRANDING_SLUG . '_custom_dashboard_widget', // Widget slug.
            $this->settings['custom_dashboard_widget_title'], // Title.
            array(
            $this,
            'addCustomDashboardWidgetContent'
        ) // Display function.
            );
    }
    
    public function addCustomDashboardWidgetContent()
    {
        echo do_shortcode($this->settings['custom_dashboard_widget_content']);
        
    }
    
    public function addCustomDashboardRSSWidget()
    {
        wp_add_dashboard_widget(TBB_BRANDING_SLUG . '_custom_dashboard_rss_widget', // Widget slug.
            $this->settings['custom_dashboard_rss_widget_title'], // Title.
            array(
            $this,
            'addCustomDashboardRSSWidgetContent'
        ) // Display function.
            );
    }
    
    public function addCustomDashboardRSSWidgetContent()
    {
        
        echo "<div>";
        wp_widget_rss_output(array(
            'url' => $this->settings['custom_dashboard_rss_widget_url'],
            'title' => $this->settings['custom_dashboard_rss_widget_title'],
            'items' => $this->settings['custom_dashboard_rss_widget_items'],
            'show_summary' => 1,
            'show_author' => 0,
            'show_date' => 1
        ));
        echo "</div>";
        
    }
    
    public function removeHelpTabs()
    {
        $screen = get_current_screen();
        $screen->remove_help_tabs();
    }
    
}