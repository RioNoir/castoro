<p align="center">
<img src="https://raw.githubusercontent.com/RioNoir/castoro/refs/heads/main/src/img/banner-light.png" alt="Castoro" style="margin: 20px 0; width: 400px; height: auto;">
</p>

# Castoro Documentation

Welcome to the official Castoro documentation, here you will find comprehensive guides to its features.

## Basic settings

In addition to the basic Jellyfin settings, available in the official documentation, you will find specific sections where you can change Castoro settings.

In this section you can change the server url, which cannot be configured through Jellyfin's network settings (this is because Castoro already uses a reverse proxy by itself to work).

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/1.png)

You will also be able to configure the settings for Addons, Global Searches, and Streams (content video resources). 

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/2.png)

You can also configure additional services, such as the TMDB API to use it in searches, MediaFlow Proxy to play content through it, and configure an HTTP Proxy for all http requests that Castoro makes (for searches and addons, not streams).

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/3.png)
![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/4.png)

You also have the ability to configure the tasks that Castoro does in the backround and specify how often it should do them.

## Tasks

Just like Jellyfin, Castoro also has tasks, these are run automatically based on the configuration but can be run manually in the task section if needed.

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/5.png)


## Libraries

On initial setup Castoro will create all the folders he needs and automatically insert the various contents. These automatically created libraries cannot be deleted, but there is nothing to prevent you from creating new ones and putting other contents in there. It is recommended not to insert manual content inside the folders created automatically by Castoro, however, you can still do so if you maintain the correct structure of the folders.

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/6.png)

## Global Search

Global Search leverages the API and Addons to show you the content you are looking for. Once you find it you can easily add it to your library via the heart icon (in some apps it is a star). After a few seconds you will find the content in your library.

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/7.png)

## Direct Url

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/10.png)

The Direct Url feature, allows a given piece of content to be played directly from a link, somewhat like how it works for .strm files. The advantage is the possibility of having dynamic parameters. There are several dynamic parameters:

- **ep_***%format%*

Inserts the “effective” episode number into the link. The %format% should contain the formatting of the episode number in the link. E.g. **ep_%04d**, it will restate 0004 if the episode is number 4.

- **epc_***%format%*

It inserts the episode number into the link based on the season numbering, so if the episode is 1000 but in the season is 7 then it will insert 7. The %format% should contain the formatting of the episode number in the link. E.g. **epc_%04d**, it will restate 0007 if the episode is number 7.

- **sn_***%format%*

Inserts the season number into the link. The %format% should contain the formatting of the season number in the link. E.g. **ep_%02d**, will restate 03 if the season is season number 3.

Formats are based on php [sprintf](https://www.php.net/manual/en/function.sprintf.php) function.
The final example with parameters should look something like this:

*https://personal-storage.castoro/series-name/season-{sn_%02d}/episode-{ep_%03s}.mp4*

It will return such a link depending on the season and episode:

*https://personal-storage.castoro/series-name/season-01/episode-004.mp4*

Direct Urls are configurable at the Movie, TV Series, TV Series Season, and individual TV Series Episode level. When configured at the TV Series and/or Season level, if configured via parameters, all episodes will inherit the correct links.
Direct Urls take precedence over Addons from the moment you choose to play a content in "automatic" mode.

DISCLAIMER: The source from where to reproduce the content must be legitimate and you must have the rights to stream it.

## Addons

Now to the juiciest feature of Castoro, Addons. Addons allow you to add content, view it and keep it up-to-date. There are (currently) two types of Addons:

- Catalogs Addons
- Streams Addons

Nothing prohibits an Addon from being both.

For the future these addons we want to make them usable for all media content in Jellyfin, so also for Music and Books, but at the moment they only work with Movies and TV Series (or general video content).

### What does an addon look like?
An Addon is nothing more than a url to an external repository (somewhat like Jellyfin plugins), and it has this syntax:

https://my-addon-url.castoro/manifest.json

This url will return a JSON with all the configuration of the Addon, with parameters like these:

- ***id***: Unique identifier of the addon.
- ***version***: Current version of the addon
- ***name***: Name of the addon
- ***logo***: Logo of the addon
- ***resources***: An array of the resources that addon has (e.g. catalog, stream)

Addons are based on this [SDK](https://github.com/Stremio/stremio-addon-sdk).

### How do you install an Addon?

Installing an Addon is super easy, just go to Settings and Catalog, from there clicking on the gear icon in the top left corner will allow you to import the Addon repository.

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/11.png)

Once the repository is added the addon will be automatically installed.

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/12.png)

### How to use an Addon?

Once installed, you don't need to do anything else; the system is ready for you to take advantage of the addon for the purpose for which it was added.

If the addon contains a Catalog, you will see the new **Discover** section on the homepage, allowing you to browse the catalog and view its contents.

![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/13.png)
![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/14.png)
![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/15.png)
![castoro](https://raw.githubusercontent.com/NsCRio/castoro/refs/heads/main/docs/images/16.png)

A catalog does not allow you to view content, only to browse through it and eventually add it to the library to be viewed via an <u>Stream Addon</u>.

If the addon is a <u>Stream Addon</u> and contains playable links, you only need to open a Movie or TV Series (you have already added to the library) to see the list of sources from where you can play the content.

**DISCLAIMER**: The source from where to reproduce the content must be legitimate and you must have the rights to stream it. We take no responsibility for illicit use by either the user of the Addon or the creator of the Addon.

## Data Structure

The folder structure of Castoro is very simple, all data is contained within the /data folder, here are the following folders:

- **app**, where all the Castoro data is located, with the database and the cache and session folders.
- **jellyfin**, the jellyfin data folder.
- **library**, where is contained all the library structure that Castoro creates and where are all the media content files added to the library.

There is also inside the data folder a config.json file that is the basic configuration of Castoro, with all the settings configured.
It is important to make frequent backups of the /data folder.

DISCLAIMER: Castoro is still in beta, so we take no responsibility for any loss of data.

## User Management

User management is handled by Jellyfin, all users have access to Castoro features such as Global searches, adding new content to the library, and playing content via Addons. All actions such as accessing certain libraries, editing metadata, and deleting content are manageable through classic Jellyfin settings.

