window.onload = function(){
    $("#start").click(()=>{
        Quagga.init({
            inputStream:{
                name:"Live",
                type: "LiveStream",
                target: document.getElementById("quagga")
            },
            decoder: {
                readers: [ "ean_reader" ]
            },

        }, err=>{
            if(err){
                console.log(err);
                return;
            }
            console.log("Initialization finished");
            Quagga.start();
        });


        Quagga.onProcessed(result=>{
            if(result == null)
                return;
            if(typeof(result) != "object")
                return;
            if(result.boxes == undefined)
                return;        
            var ctx = Quagga.canvas.ctx.overlay;
            var canvas = Quagga.canvas.dom.overlay;
            ctx.clearRect(0, 0, parseInt(canvas.width), parseInt(canvas.height));
            Quagga.ImageDebug.drawPath(
                result.box,
                {x: 0, y: 1},
                ctx,
                {color: 'red', lineWidth: 3}
            );
            
        });

        Quagga.onDetected(result=>{
            console.log(result.codeResult.code);
            $("#res").val(result.codeResult.code);
            console.log("stopped");
            Quagga.stop();
        });
    })
};

$("start").click() = function(){
    Quagga.start();
};
    
