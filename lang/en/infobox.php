<?php

$tutorialUrl = route('tutorial.index');

return ['text' => <<<INFOBOX
The goal of this project is to obtain information on what has happened to the missing Anna Jansone.

Anna went missing on 1st of November 2023. A forest track near the 5.5 km mark of highway P101 (in Latvia) is considered to be her last known location.
Since the 2nd of November 2023 we've obtained no new info on what has happened to Anna or in which direction did she go.
Probably she had grey coat jacket, black ankle boots and black jeans.
It's possible she also had a backpack with red detail and maybe a one liter bottle of antifreeze.

**Please carefully review the images and write down the info if anything on the image might be a clue as to where has Anna gone.
It can be anything that does not fit the image's environment like a shoe, a bag or an object of uncommon shape.**
How to spot objects? Try it out [here]($tutorialUrl)!

<details>
<summary>
What are those images? How to view them?
</summary>

Those are photos and sonar recordings (recognizable by the orange colors) from the neighborhood of her disappearance.

Photos are aerial images from height up to 70 meters. You might need to zoom in significantly to look at everything that can be seen on the image.
They can be zoomed using the mousewheel or the pinch gesture on touchscreens and touchpads.
The zoomed images can be panned by dragging the mouse cursor or your finger (on touchscreens).

Under the minimap in the info block there is the name of the image. Click on it to open additional info about the image — direct link, location and other metadata.
The location can also be seen on the minimap, along with the locations of nearby images.

If you find it easier to focus on a singel kind of images, you can use the "Continue with ... image" selection to get the next image from the same set instead of a random one.

The button at the top right of the image viewer can be used to toggle panning without limits to drag an object besides the scale line.
</details>

<details>
<summary>What are those orange images?</summary>

Sonar recordings display the underwater scene. The width of the "belt" is 10–50 meters, usually 20–40.
There are two kinds of images: originals with a distinctive zone along the midline and SRC (slant range corrected) without such zone.

Please note that the geometry may be deformed and the image quality may also be muddy, so view the images with additional attention.
</details>

<details>
<summary>
When to use which buttons?
</summary>

If the image contains anything that might provide clues on what has happened to Anna or where has she gone, type it into the "Anything suspicios?"
text area and press "Submit". The same course of action should be taken when you are unsure and it seems that the place should be checked, for example
if there's a hut that should get looked into.

The notable spot can and should be marked on the map by clicking. The added markers will be stored together with the other info.

In case there's an issue with the image itself (e.g. unreasonable amount of blur), please click on "Is the image bad?", describe the issue in the area that appears and Submit.
You may fill both text areas on the same review.

If you want to view a neighbouring photo, click on the dots in the minimap — the links to the images in the clicked location will appear under the map.

If it's clear that the area contains nothing notable, press the green "Reviewed, nothing to note here" button.

The system will try to remember your reviews and not show the reviewed images again to the same reviewer.

If a picture seems too daunting to meticulously check it at this moment, you may press "Skip this image" at the bottom.
The skipped images will be shown again if you've reviewed all the other images already.
</details>

Geodata related to the search — the searched areas, noted objects and so on can be seen on <a href="https://ej.uz/AnnasVietas" target=_blank>ej.uz/AnnasVietas</a> (texts in Latvian).

If you have any other info about what might've happened to Anna, please get in touch
via [+37127020337](tel:+37127020337) (available on WhatsApp, Signal, Telegram),
juris@glaive.pro or the <a href="https://www.vp.gov.lv/en" target=_blank>State Police</a>.
INFOBOX,
];
