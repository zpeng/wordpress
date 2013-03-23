=== RSVP Plugin ===
Contributors: mdedev
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mikede%40mde%2ddev%2ecom&lc=US&item_name=Wordpress%20RSVP%20Plugin&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: rsvp, reserve, wedding, guestlist
Requires at least: 3.0
Tested up to: 3.5.0
Stable tag: 1.6.5

Easy to use rsvp plugin originally created for weddings but could be used for other events.

== Description ==

This plugin was initially created for a wedding to make rsvp'ing easy as possible for guests. The main things we found lacking 
in existing plugins was:

* Couldn't relate attendees together so one person could easily rsvp for their whole family
* Required people to remember/know some special knowledge (a code, a zipcode, etc...)

The admin functionality allows you to do the following things:

* Specify the opening and close date to rsvp 
* Specify a custom greeting
* Specify the RSVP yes and no text
* Specify the kids meal verbiage
* Specify the vegetarian meal verbiage 
* Specify the text for the note question
* Enter in a custom thank you
* Create a custom message / greeting for each guest
* Import a guest list from an excel sheet (column #1 is the first name, column #2 is the last name, column #3 associated attendees, column #4 custom greeting)
* Export the guest list
* Add, edit and delete guests
* Associate guests with other guests
* Create custom questions that can be asked by each attendee
* Have questions be asked to all guests or limit the question to specific attendees
* Specify email notifications to happen whenever someone rsvps

If there are any improvements or modifications you would like to see in the plugin please feel free to contact me at (mike AT mde DASH dev.com) and 
I will see if I can get them into the plugin for you.  

Available CSS Stylings: 

* rsvpPlugin - ID of the main RSVP Container. Each RSVP step will be wrapped in this container 
* rsvpParagraph - Class name that is used for all paragraph tags on the front end portion of the RSVP
* rsvpFormField - Class for divs that surround a given form input, which is a combination of a label and at least one form input (could be multiple form inputs)
* rsvpAdditionalAttendee - Class for the div container that holds each additional RSVP attendee you are associated with
* additionalRsvpContainer - The container that holds the plus sign that allows for people to add additional attendees
* rsvpCustomGreeting - ID for the custom greeting div that shows up if that option is enabled
* rsvpBorderTop - Class for setting a top border on certain divs in the main input form
* rsvpCheckboxCustomQ - Class for the div that surrounds each custom question checkbox 
* rsvpClear - A class for div elements that we want to use to set clear both. Currently used only next to rsvpCheckboxCustomQs as they are floated

== Installation ==

1. Update the `rsvp` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add and/or import your attendees to the plugin and set the options you want
1. Create a blank page and add 'rsvp-pluginhere' on this page

== Frequently Asked Questions ==

= Why can't this plugin do X? =

Good question, maybe I didn't think about having this feature or didn't feel anyone would use it.  Contact me at mike AT mde DASH dev.com and 
I will see if I can get it added for you.  

== Screenshots ==

1. What a list of attendees looks like
1. The options page
1. The text you need to add for the rsvp front-end

== Changelog ==

= 1.6.5 =
* Fixed another bug so that the RSVP form works with more single page layouts
* Fixed some layout issues related to whitespace in the output
* Added an option to hide the note field from the front-end
* Added passcodes to the export
* Added passcodes to the import 
* Made it so all of the front-end text was translatable 

= 1.6.2 = 
* Fixed a bug so that the rsvp form works with single page layouts
* Fixed a bug where the passcode was not being checked. Thanks to Jency Rijckoort for reporting the issue. 

= 1.6.1 = 
* Fixed a bug with the jQuery validate library that was causing an error with the 3.5.0 media manager. Thanks to Topher Simon for reporting the issue. 

= 1.6.0 =
* Added in internationalization for the front-end piece of the RSVP plugin
* Changed the front-end layout from a table based structure to more divs with classes to be used for styling
* Added in sytling
* Moved some CSS and JavaScript to separate files instead of being included inline

= 1.5.0 =
* Made it so the plugin would only replace the plugin short code and not all of the page's content
* Changed it so when the site is running over SSL the included javascript files would also be loaded over SSL
* Removed deprecated calls to session_unregister so it would work correct on PHP 5.4 and above
* Changed it so on new installs of RSVP fields that have free-form text will always be UTF-8 to minimize issues with unicode characters

= 1.4.1 = 
* Fixed a bug where the passcode field would not always get created when upgrading.  This caused the attendee list to now display in the admin area
* Also added some finishing touches to the passcode feature as it was released a little bit too soon

= 1.4.0 = 
* Added in the option to require a passcode when RSVPing. 

= 1.3.2 =
* Added in the option to change the "welcome" text
* Added in the option to change the "So, how about it?" text
* Fixed an issue with some MySql installations choking on the note field not having a default value

= 1.3.1 =
* Added in a debug option to help identify issues with queries saving to the database
* Changed how the scripts and stylesheets get added so there would be less conflicts with themes

= 1.3 =
* Made it so custom questions showed up on the attendee list page
* Added in a radio button as a custom question type
* Changed the RSVP notification email to include the RSVP status
* Fixed an issue with when searching for people with an apostrophe in it, it would display with the added escaping. Made sure to remove the escaping.  
* Added in the veggie and kids meal total count to the list of attendees in the admin area
* Made it so admins can change the RSVP status
* Fixed an issue with international characters not being displayed correctly on both the admin and public areas of the plugin

= 1.2.1 =
* Fixed a bug that was causing an error on activation for people with servers that did not have short open tags configured

= 1.2.0 =
* Fixed a bug in the adding of additional guests when there are custom questions
* Added the ability to have a question be public or private. If a question is marked as private then only the selected attendees will be able to answer the question

= 1.1.0 =
* Tested the plugin on 3.0.0
* Added in the ability to sort custom questions
* Fixed an issue where you could not mass delete custom questions

= 1.0.0 =
* Removed some default text that pointed to my wedding site, doh.
* Created the ability to not allow additional attendees be added
* Created the ability to be notified via email whenever someone rsvps
* Added the ability to specify custom questions for each rsvp.  

= 0.9.5 =
* Fixed a major bug that would not create the correct sql tables during initial install, thanks to everyone for letting me know. 

= 0.9.0 = 
* Fixed the options page so it works in MU switched from the old options way with using the newer methods that are only for 2.7+.
* Added the option of custom messages for each attendee. 
* Small bug-fixed and code refactoring that I noticed while testing.

= 0.8.0 =
* Did better variable checking on the sorting functions, as warning could show up depending on the server configuration.
* Fixed an issue with the checkbox selector in the attendee list not working in Wordpress 2.9.2
* Added an export button to the attendee list.  When clicking this button the list will export in the same sorting order as the list
* Added the ability to associate attendees on import
* Added in checking when importing so names that already exist don't get imported
* Fixed a warning when session variables were not created on the front-end greeting page

= 0.7.0 =
* Fixed a bug reported by Andrew Moore where when adding a new attendee and an option to hiding an answer the answer would still be visible

= 0.6.0 =
* Fixed a bug reported by Andrew Moore in the import feature that would not allow most files from being uploaded, doh!
* Fixed a few other small warnings and gotchas (also reported by Andrew Moore)

= 0.5.0 =
* Initial release

== Upgrade Notice ==
* To upgrade from 0.5.0 to 0.6.0 just re-upload all of the files and you should be good to go.  Really the only change was to wp-rsvp.php so uploading this changed file is all that is needed.  
* To upgrade to 0.9.0 at minimum copy over wp-rsvp.php and rsvp_frontend.inc.php and go to the attendeees list.  Preferably deactive and reactivate the plugin so it is for sure that the database changes happen. 
* To upgrade to 1.0.0 at minimum copy over wp-rsvp.php and rsvp_frontend.inc.php and deactive and reactivate the plugin to get the latest database changes.  