=== Callcap Webmatch ===
Contributors: Callcap
Tags: call tracking, phone tracking, phone numbers
Requires at least: 4.0
Tested up to: 4.9.6.2
Stable tag: 4.9.6.2
License: GPL v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

Works with Webmatch by Callcap to associate pageviews with phone calls and dynamically change phone numbers on your Wordpress page using your Webmatch phone numbers.

== Description ==
"Webmatch" is a call-tracking feature provided by Callcap that associates phone calls with specific pageviews to bridge the gap between advertising campaigns and incoming phone calls.

Webmatch allows a company to bridge the gap between basic web analytics and direct sales via phone calls. If a call leads to a sale, Webmatch can help you see where the initial visit came from, what ad campaign it may have run under, and what page the user was on when they called you.

At it's most basic, Webmatch will simply associate recent calls to recent pageviews, but with Dynamic Rotator enabled, Webmatch can show unique phone numbers to visitors to more accurately track their statistics.

== Installation ==
In order for the Callcap Webmatch plugin to work, you must have Webmatch enabled on your Callcap account. More information can be found here: http://www.callcap.com/help/webmatch/

From the Wordpress admin panel, click "Plugins", search for "Callcap Webmatch", install the plugin, then click "Activate"

Full documentation located at https://www.callcap.com/help/webmatch-wordpress

== Changelog ==

= 1.6.5 =
- Fixing a bug that would prevent UTM variables from sending in some circumstances

= 1.6 =
- Updated the help documentation in the plugin so it's easier to configure the plugin
- Fixed a bug where there may be no "add new campaign" button
- Added links to further documentation in the bottom of the plugin page
- Nice one!

= 1.5 =
- Made some improvements to the UI so it's a bit easier to understand what's going on
- You can now cancel an edit
- Moved "Load UTM Parameters" and "Pull Parameters" into one "Option" selected via a radio button. These should not have been selected simultaneously as it could overwrite some data. This change prevents that.
- What a play!

= 1.4 =
- Moved scripts to enqueue earlier during page-load so rotators will replace phone numbers faster.
- Removed stray references to KCAP variables in code. KCAP variables will return with Wordpress 3.0
- Rewrote logic to only add params if they're set to true.
- All yours!

= 1.3 =
- Added ability to edit existing campaigns
- Added "phone link" feature - turns phone numbers into clickable links on mobile devices
- Fixed a bug where the page didn't confirm with user before deleting the campaign
- Removed ability to use KCAP variables from plugin. These are complex to implement, don't play well with WordPress's framework and really require manual coding to work well.
- In position!

= 1.2 =
- Fancy new documentation! Find more at https://www.callcap.com/help/webmatch
- Removed "Instance Name" as it's no longer used. Using "Label" as a generic user-facing label going forward.
- Tested compatibility with  Wordpress 4.6.1
- Savage!

= 1.1 =
- Major layout/design updates
- Allowed multiple rotators/campaigns per site
- Enabled targeted CSS class for rotators.
- Added UTM Variable tracking
- Added UTM Search Term tracking
- Added Pull Parameters functionality
- Added KCAP variable manual tracking
- Better code commenting
- Better terminology, more user-friendly text
- Added a "Label" field for better sorting of campaigns
- Consolidated javascript code
- 4.2 gallons of coffee consumed
- Wow! What a save!

= 1.0.9 =
- Renamed database entries to include 'Callcap' for easier troubleshooting/uninstallation
- Modified how data is stored in database so it's using only a single cell entry and all data is in a multidimensional array

= 1.0.4 =
- Consolidating some terminology in the plugin
- Testing compatibility with Wordpress 4.4.1

= 1.0.3 =
- General cleanup *salute*

= 1.0.2 =
- Improved WP standardization

= 1.0.0 =
- Initial launch
