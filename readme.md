# Callcap Webmatch Wordpress Plugin #

This plugin enables Wordpress.org hosted sites to easily implement Webmatch features without the operator of the site having to work with code.

https://wordpress.org/plugins/callcap-webmatch/
https://www.callcap.com/help/webmatch
https://www.callcap.com/help/webmatch-wordpress

### Setup ###

The easiest method for setup is to add a new plugin from the Wordpress dashboard and search for "Callcap" or "Webmatch" in the Wordpress plugin directory, then click the install button.

Alternatively, you can navigate directly to the URL for the plugin hosted on wordpress.org (here: https://wordpress.org/plugins/callcap-webmatch/) and download the .zip file, then extract it into the wp-content/plugins/webmatch/ folder of your website.

### Development Setup ###

Reference Links:
https://wordpress.org/plugins/about/
https://wordpress.org/plugins/about/svn/

You can either use a local webserver (WAMP, whatev) with a Wordpress.org install to test this plugin, or just test it on a live site somewhere. I tested it on my blog to make sure it was working in the wild.

Wordpress uses SVN repositories for their plugins. This (obviously) is a git repository for development and version control purposes on our end.

The Wordpress account that has access to the SVN repo is tied to api@callcap.com and the credentials are available in PassMan.

You'll have to install SVN software to manage the repo. I chose to use TortoiseSVN. The folder structure inside the SVN repo is critical to managing the plugin's features on the Wordpress Plugin Directory. See below:

* (root folder)
    * **Assets** - Used mainly for graphics - filenames are very specific in order to work, don't change them
    * **Branches** - Used for branches but since we use git we don't touch this
    * **Tags** - Used to store older versions of the plugin. Each subfolder here should match the plugin version (ie. 1.0.3, etc)
    * **Trunk** - The current working version of the plugin
    * **Readme.txt** - This is a very specifically-formatted file that Wordpress parses to generate the Plugin page. https://wordpress.org/plugins/about/readme.txt

**Notes:**
* SVN "commit" is similar to Git's "push" - Committing is pushing the file to the remote SVN repo.
* Don't use your install folder in wp-content/plugins/webmatch as your root folder for your git repo - uninstalling the plugin will delete your repo files

### Roadmap ###

* Form Validation
* Help popups/tooltips and general "help" integration

### Contact ###

* Developed at Callcap
* Written by Seth Duncan
* dev@callcap.com
* sduncan@callcap.com
