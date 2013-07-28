visual_bookmarks
================

Alternative bookmark manager for ownCloud.
Displays bookmark data visually as coloured flags and has a searchable index to lookup bookmarks by title, description or content type.

This app is in a pre-alpha stage and should not be considered stable or feature complete.

_Note: this app requires the installation of the ownCloud AppFramework - see step 1_

####Visually display your bookmarks
![screenshot from 2013-07-28 09 30 02](https://f.cloud.github.com/assets/774663/867631/a26d7bfa-f716-11e2-92f0-db094f877573.png)

####Edit inline and add searchable descriptions
![screenshot from 2013-07-28 09 30 15](https://f.cloud.github.com/assets/774663/867633/a3047c80-f716-11e2-8ea7-8b8be3e39318.png)

####Import & export at anytime
![screenshot from 2013-07-28 09 30 27](https://f.cloud.github.com/assets/774663/867632/a2e04072-f716-11e2-84a8-7a29d9beb4b8.png)

##Installation

1. Clone or upload ownCloud [appframework](https://github.com/owncloud/appframework) into your apps folder and enable
2. Clone or upload [visual_bookmarks](https://github.com/owncloud/appframework) into your apps folder and enable.

##Feature Roadmap

This is the roadmap of features that are currently being worked on and will appear in future versions of visual_bookmarks.

- Extend the indexer to save an image for contentType image/* bookmarks or text/html bookmarks that have an image in the metadata and display that on top of the link area.
- Extend the indexer to store a copy of contentType text/html sites and make it searchable by the lucene module.
- Provide a solution to sync bookmarks between various browsers on all common devices.

##Maintainer:

- [Daniel Givney](https://github.com/dgivney)
