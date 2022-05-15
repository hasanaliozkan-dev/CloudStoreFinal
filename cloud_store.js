
var basketpro = []


function addToBasket(){
    var parent = event.target.parentElement.parentElement.children;
    console.log(parent[2])
    //constructor(title,desc,quantity,price,image_url,category){
    let image_url = parent[0].src;
    let title = parent[1].innerHTML;
    let category = parent[2].innerHTML;
    let desc = parent[3].innerHTML;
    let price = parent[4].innerHTML;
    let quantity = parent[5].innerHTML;


    let temp = new Cloud(title,desc,quantity,price,image_url,category);

    basketpro.push(temp)
    displayBasket()

}

function displayBasket(){

    let basketcont = document.getElementById("basket");
    basketcont.innerHTML = "<div class=\"total\" id=\"total\">\n" +
        "        <h4> TOTAL PRICE:  </h4>\n" +
        "        <strong><p style=\"text-align: center; margin-top: 22px; bottom: 0\">"+totalPrice()+" ₺</p></strong>\n" +
        "    </div>\n" +
        "    <button id=\"buyButton\"  disabled type=\"button\" style=\"background-color: #FFC4FF; float: right;margin-top: 25px;margin-right:25px; height: 30px; width: 70px;border-radius: 25%; border: 0px\" onclick=\"openPayment()\" > <strong>BUY </strong></button>\n" +
        "\n" +
        "\n";
    if(basketpro.length>0){
        document.getElementById("buyButton").disabled = false;
    }
    for (let i = 0; i < basketpro.length; i++) {
        basketcont = document.getElementById("basket");
        let totall = document.getElementById("total");
        let basket_element = document.createElement("div");
        basket_element.classList.add("basket-element");
        let basket_photo = document.createElement("img");

        basket_photo.src = basketpro[i].image_url;
        basket_photo.classList.add("basketrow");
        basket_photo.classList.add("display-horizantally");
        let productname = document.createElement("h4");
        productname.classList.add("display-horizantally");
        let realproductname = document.createTextNode(basketpro[i].title);
        productname.appendChild(realproductname);
        let priceproduct = document.createElement("p");
        priceproduct.classList.add("display-horizantally")
        let realprice = document.createTextNode(basketpro[i].price);
        priceproduct.appendChild(realprice)
        let removebutton = document.createElement("button")
        removebutton.classList.add("display-horizantally");
        removebutton.classList.add("cart_button");
        let minus = document.createTextNode("-");
        removebutton.onclick = removeFromBasket;
        removebutton.appendChild(minus);
        basket_element.appendChild(basket_photo);
        basket_element.appendChild(productname);
        basket_element.appendChild(priceproduct);
        basket_element.appendChild(removebutton);
        totall.before(basket_element)
    }



}

function removeFromBasket(){
   let output=  event.target.parentElement.children;

   let product_name =output[1].innerHTML;
    for (let i = 0; i < basketpro.length; i++) {
        if(basketpro[i].title === product_name){
            basketpro.splice(i,1);
            break;
        }
    }
    displayBasket();

}
function totalPrice(){
    let total = 0;
    for (let i = 0; i < basketpro.length ; i++) {
        total += parseInt(basketpro[i].price.split(" ")[1]);
    }
    return total;




}

function openBasket(){

    if(document.getElementById("basket").style.visibility=== "hidden"){
        document.getElementById("basket").style.visibility= "visible";
        displayBasket()
    }
    else {

        document.getElementById("basket").style.visibility= "hidden"
    }
    totalPrice()

}
function openPayment(){
    document.getElementById("payment_method").style.visibility = "visible";
    document.getElementById("basket").style.visibility = "hidden";
}
function closePayment(){
    document.getElementById("address").value = "";
    document.getElementById("cash").checked = false;
    document.getElementById("creditcard").checked = false;
    document.getElementById("payment_method").style.visibility = "hidden";
}
function confirm(){
    if(document.getElementById("address").value === ""
        || (document.getElementById("cash").checked === false
            && document.getElementById("creditcard").checked === false)){
        alert("Please fill all empty places!!!")
    }
    else{
        basketpro = []
        document.getElementById("address").value = "";
        document.getElementById("cash").checked = false;
        document.getElementById("creditcard").checked = false;
        document.getElementById("payment_method").style.visibility = "hidden";

    }
}
