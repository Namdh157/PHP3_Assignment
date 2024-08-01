var currentIndex = 0;
var url = "storage/images/slider";
var imgs = ["/slide-1.jpg","/slide-2.jpg"];

function nextImg(){
    if(currentIndex < imgs.length - 1){
        currentIndex++;
    }else{
        currentIndex = 0;
    }
    document.getElementById('anh').src= url + imgs[currentIndex];
    console.log(url+imgs[currentIndex]);
}
function previousImg(){
    if(currentIndex>0){
        currentIndex--;
    }else{
        currentIndex = imgs.length-1;
    }
    document.getElementById('anh').src= url + imgs[currentIndex];
    console.log(url+imgs[currentIndex]);
}