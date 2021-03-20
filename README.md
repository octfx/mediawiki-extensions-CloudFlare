# CloudFlare
![](https://github.com/StarCitizenTools/mediawiki-extensions-CloudFlare/workflows/MediaWiki%20CI/badge.svg)

## Requirements
* [MediaWiki](https://www.mediawiki.org) 1.35 or later

## Installation
You can get the extension via Git (specifying CloudFlare as the destination directory):

    git clone https://github.com/StarCitizenTools/mediawiki-extensions-CloudFlare.git CloudFlare

Or [download it as zip archive](https://github.com/StarCitizenTools/mediawiki-extensions-CloudFlare/archive/master.zip).

In either case, the "CloudFlare" extension should end up in the "extensions" directory 
of your MediaWiki installation. If you got the zip archive, you will need to put it 
into a directory called CloudFlare.

## Configurations
Name | Description | Values | Default
:--- | :--- | :--- | :---
`$wgCloudFlareZoneId` | Your CloudFlare Zone ID | string | `null`
`$wgCloudFlareApiToken` | Your CloudFlare API token | string | `null`
`$wgCloudFlareAccountId` | Your CloudFlare account ID | string | `null`