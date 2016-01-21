/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 */
Gallery = {
    start: function() {
        var images = $('#gallery-wrap .gallery-img'),
            interval = 5000,
            fadeTime = 1000,
            index = 0,
            total = images.length,
            imgLoaded = false;

        if (total <= 0) {
            return;
        }

        var firstItem = $(images[index]),
            img = firstItem.find('img'),
            intervalCheckImgLoad;

        images.hide();
        firstItem.show();

        img.load(function(){
            $('#gallery-wrap').height(img.height());
            imgLoaded = true;
        });
        intervalCheckImgLoad = window.setInterval(function(){
            if (!imgLoaded) {
                img = firstItem.find('img');
                $('#gallery-wrap').height(img.height());
            }
            clearInterval(intervalCheckImgLoad);
        });


        $(window).resize(function() {
            $('#gallery-wrap').height(img.height());
        });
        
        if (total < 2) {
            return;
        }


        var intervalId = window.setInterval(function(){
            changeImage('right');
        }, interval);
        $('#banner-btn-right').click(function(){
            clearInterval(intervalId);
            changeImage('right');
        });
        $('#banner-btn-left').click(function(){
            clearInterval(intervalId);
            changeImage('left');
        });

        function changeImage(direction){
            var currentIndex = index;
            if (direction === 'right') {
                index++;
            } else if (direction === 'left') {
                index--;
            }
            handleIndex();
            $(images[currentIndex]).fadeOut(fadeTime);
            $(images[index]).fadeIn(fadeTime);
        }

        function handleIndex(){
            if (index < 0) {
                index = total - 1;
            } else if (index > total - 1) {
                index = 0;
            }
        }
    }
};
