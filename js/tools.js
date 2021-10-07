var data = document.getElementsByClassName('img-fluid bb');
const canvas2 = document.getElementById('myCanvas');
function imgToCanvas()
{
    var context = canvas2.getContext('2d');
    var x = 0;
    var y = 0;
    canvas2.width = document.getElementById('video_overlays_img').width;
    canvas2.height = document.getElementById('video_overlays_img').height;
    var width = document.getElementById('video_overlays_img').width;
    var height = document.getElementById('video_overlays_img').height;
    var imageObj = new Image();
    imageObj.src = document.getElementById('video_overlays_img').src;
    context.drawImage(imageObj, x, y, width, height);
}

function onFileSelected(event) {
    var selectedFile = event.target.files[0];
    var reader = new FileReader();
  
    var imgtag = document.getElementById("output");
    imgtag.title = selectedFile.name;
  
    reader.onload = function(event) {
      imgtag.src = event.target.result;
      imgtag.style.width = "590px";
      imgtag.style.height = "345px";
    };
    imgtag.onerror = function(){
        if(alert("image is broken ....")){}
        else{window.location.reload();}
    }
    reader.readAsDataURL(selectedFile);
    data[0].style.pointerEvents = 'auto';
    data[1].style.pointerEvents = 'auto';
  }
function change(src)
{
    document.getElementById('video_overlays').style.display = "block";
    document.getElementById('video_overlays_img').src = src;
    if(document.getElementById('campress'))
    {
    document.getElementById('campress').disabled = false;
    document.getElementById('campress').onclick = clone;
    }
    else
    {
    document.getElementById('campress2').disabled = false;
    document.getElementById('campress2').onclick = clone2;
    }
}