##Live URL
[p2.ritarafaeli.me](http://p2.ritarafaeli.me)


##Project Description
XKCD Password Generator (Project 2) uses basic php to scrape common English words from [paulnoll.com](http://www.paulnoll.com/Books/Clear-English/) and generates a password based on user configuration. For example, you can choose to generate a password using 5 words, all uppercase, and hyphenated, which gives you "GLASS-COACH-KEY-IMPROVE-REALIZE".

##Demo
TBU

##Details
#### scrape.php
 Used to scrape through 15 pages of common English words from the above mentioned site.
#### generate.php
 Uses form inputs, including list of words generated from `scrape.php` to output an xkcd password.
#### app.js
 Utilizing AngularJS for MV* architecture. Makes calls to server side (php files), and displays data on main page [making it great for single-page development]
#### index.htm
 Makes a call to `app.js`'s `scrapeWords()` function when the page loads, which extracts all of the words in `<li></li>` tags from the earlier mentioned url. Displays the form used for password configuration and includes form validation.

##Plugins/Libraries
* [Bootstrap](http://getbootstrap.com/)
* [AngularJS](https://angularjs.org/)
