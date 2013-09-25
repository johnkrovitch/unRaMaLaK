unRamalak and Gmf Installation
========================

1) version 0.1 "Working Panda" (summer 2013 ? lol)
----------------------------------

TODO :
    * creates textures algorithm to not load always the same textures

Features :
    * simple map creation
    * units move and fight (melee and distance)
    *
    * map drag&drop on chrome (with units, textures and building)

Bugs :
    * FIXED bug on the second map saving in crud (PHP)
    * FIXED bug on map drag&drop : textures does not move
    * FIXED : drag does not work on textures
    * bug : map can be drag out of out canvas
    * bug : notifications does not work anymore
    * bug : units selection does not work (CURRENT)


2) version 0.2 "Tested Bamboo"
----------------------------------

Improvements :
    * php & js TESTED !!!
    * map texture loading (remove ajax call ?) (JS, PHP)
    * movement animation (renderer.animate()), to improves firefox performances (JS)
    * php game security
    * includes smooth transitions between contiguous textures
    * improves svg management