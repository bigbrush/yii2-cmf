# Using the 'parallax' theme

Big Cms comes with a default theme based on [Materializecss](http://materializecss.com/templates/parallax-template/preview.html).

To get the parallax experience from the theme a couple of things needs to be setup. This is covered in this guide.


## Installing

The default theme comes with 3 additional blocks. 2 that creates the parallax effect and 1 that creates a Materializecss nav bar.

With the main menu navigate to `System->Extensions` and install the 3 blocks. Use the following namespaces:
  - `app\themes\parallax\blocks\MaterializeNav`
  - `app\themes\parallax\blocks\ParallaxImage`
  - `app\themes\parallax\blocks\ParallaxText`

The `name` of each block is up to you.


## Creating the blocks

With the main menu navigate to `Blocks` and create the following 6 blocks:

  - MaterializeNav - creates nav bar based on the menu you choose.
  - 3 x ParallaxImage - creates a parallax image block
  - 2 x ParallaxText - creates a parallax content block

**ParallaxImage**
Either find 3 images on Google or use the 3 images located here: `themes/parallax/images`. These images are the default
Materializecss images. When using the images that comes with the theme they should be uploaded to the file manager. You can
do this when selecting the images by simply draggind and dropping them in the file manager.

Create 3 of the `ParallaxImage` blocks and select an image for each. The `content` of each block is displayed on top of
the image. Use the following names:

  - Header
  - Image 1
  - Image 2

**ParallaxText**
Use these names for the `ParallaxText` blocks:

  - Text 1
  - Text 2


## Setup a template

With the main menu navigate to `Templates` and create 2 templates. 1 for the front page and 1 for all subpages.

**Frontpage**
Create a template with the name *Frontpage* and choose the `Layout` *Frontpage*.

Assign blocks like this (BLOCK NAME => BLOCK POSITION):

  - Main menu => Main menu
  - Header => Frontpage header image
  - Image 1 => Frontpage image 1
  - Image 2 => Frontpage image 2
  - Text 1 => Frontpage text 1
  - Text 2 => Frontpage text 2

**Subpages**
Click on the `Default` template to edit it and change `Layout` to *Column2*.

Assign blocks like this (BLOCK NAME => BLOCK POSITION):

  - Main menu => Main menu

You should create additional blocks that can be used in the position `Sidebar`. The sidebar is display in the *Column2*
layout.


## Assigning the template

With the main menu navigate to `Content->Pages` and click on the page that comes installed with Big Cms to edit it. In
the `Template` dropdown choose *Frontpage* and click *Save*.

You're done. Visit the frontend by clicking the 'eye' icon i the top right corner of the backend and see the results.


## Why is this not installed with Big Cms?

Because Big Cms is an application template without content. Rather than deleting it each time it's not needed it better to
install it when it is.


## Is this template complete?

Well, if the parallax theme from Materializecss is complete then yes. But the answer problably is no, because Big Cms is focused
on customer specific solutions which, by it's nature, needs a theme customized to match specific needs.
