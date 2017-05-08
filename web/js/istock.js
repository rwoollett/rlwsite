/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

console.log("hello from istock asset");

(function($, document, window, viewport){

    var highlightBox = function( className ) {
        $(className).addClass('active');
    }

    var highlightBoxes = function() {
        $('.comparison-operator').removeClass('active');

        if( viewport.is("<=sm") ) {
            highlightBox('.box-1');
        }

        if( viewport.is("md") ) {
            highlightBox('.box-2');
        }

        if( viewport.is(">md") ) {
            highlightBox('.box-3');
        }
    }

    // Executes once whole document has been loaded
    $(document).ready(function() {

        highlightBoxes();

        console.log('Current breakpoint:', viewport.current());

    });

    $(window).resize(
        viewport.changed(function(){
            highlightBoxes();

            console.log('Current breakpoint:', viewport.current());
        })
    );

})(jQuery, document, window, ResponsiveBootstrapToolkit);

