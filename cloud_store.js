var products = []
var basketpro = []

class Cloud{
    constructor(name,desc,price,image_url){
        this.name=name;
        this.desc=desc;
        this.quantityprice=price;
        this.image_url=image_url;
    }

}


let cloud1 = new Cloud("Rainy Cloud","This cloud has a lot of raindrops...",90,"https://t3.ftcdn.net/jpg/02/61/56/24/360_F_261562470_tinafC6SOBG63BAlKNCWkex3k4yMXSUG.jpg")
let cloud2 = new Cloud("Divine Cloud","This cloud has a divine vibe...",60,"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAF9fP2OEXLkkYYVzJ-wU41TCn66LcKkH2Pg&usqp=CAU")
let cloud3 = new Cloud("Brother Clouds","These clouds always hangout...",50,"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6xIX0jn2Xets4z8xpExUUiyChv19HvH8W0w&usqp=CAU")
let cloud4 = new Cloud("Techno Cloud","This is technological cloud...",100,"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwfkV4b8WbHGJ6sGYYZX0PQvgyqnecwZFB8A&usqp=CAU")
let cloud5 = new Cloud("Colorful Cloud","This cloud is very colorful...",100,"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYCTL1hoc4aqqvFxbllePnYGzA6ehL5TvHPQ&usqp=CAU")

products.push(cloud1)
products.push(cloud2)
products.push(cloud3)
products.push(cloud4)
products.push(cloud5)

function displayProducts(){
    for (let i = 0; i < products.length; i++) {

        let row = document.getElementById("row");
        let columnn = document.createElement("div");
        columnn.classList.add("column");
        let containerr = document.createElement("div");
        containerr.classList.add("container");


        let squarre = document.createElement("div");
        squarre.classList.add("square");
        squarre.style.backgroundColor = "#FFF5F3"

        let photo = document.createElement("img");
        photo.src = products[i].image_url;
        photo.style.maxWidth ="260px";
        photo.style.height = "180px";
        photo.style.borderRadius = "15px";
        let divh1 = document.createElement("div");
        let divh1text = document.createTextNode(products[i].name);
        divh1.classList.add("h1");

        divh1.appendChild(divh1text)
        let description = document.createElement("p");
        let desctext = document.createTextNode(products[i].desc);
        description.appendChild(desctext);
        let price = document.createElement("p");
        let pricetext = document.createTextNode("Price: " + products[i].price + " ₺")
        price.appendChild(pricetext)
        let buttondiv = document.createElement("div");
        let addbutton = document.createElement("img");
        addbutton.src="images/addbasket.jpeg";
        addbutton.classList.add("addbasketclass")
        addbutton.onclick = addToBasket
        addbutton.style.border="3px solid #958EBD"

        buttondiv.appendChild(addbutton);
        squarre.appendChild(photo);
        squarre.appendChild(divh1);
        squarre.appendChild(description);
        squarre.appendChild(price)
        squarre.appendChild(buttondiv);
        containerr.appendChild(squarre);
        columnn.appendChild(containerr);
        row.appendChild(columnn);

    }

    if (basketpro.length !== 0){
        document.getElementById("buyButton").disabled = false;
    }
}

function addCloud(){
    if(document.getElementById("name").value==="" ||  document.getElementById("price").value ===""||
       document.getElementById("desc").value==="" || document.getElementById("imageurl").value==="")
    {
        alert("Please fill all empty fiels")
    }
    else {
        let cloudName = document.getElementById("name").value;
        let cloudPrice = document.getElementById("price").value;
        let cloudDesc = document.getElementById("desc").value;
        let cloudImageUrl = document.getElementById("imageurl").value;

        let temp = new Cloud(cloudName, cloudDesc, cloudPrice, cloudImageUrl);
        products.push(temp)
        let row = document.getElementById("row");
        let columnn = document.createElement("div");
        columnn.classList.add("column");
        let containerr = document.createElement("div");
        containerr.classList.add("container");
        let squarre = document.createElement("div");
        squarre.classList.add("square");
        squarre.style.backgroundColor = "#FFF5F3"


        let photo = document.createElement("img");
        photo.src = temp.image_url;
        photo.style.maxWidth = "260px";
        photo.style.height = "180px";
        photo.style.borderRadius = "15px";
        let divh1 = document.createElement("div");
        let divh1text = document.createTextNode(temp.name);
        divh1.classList.add("h1");

        divh1.appendChild(divh1text)
        let description = document.createElement("p");
        let desctext = document.createTextNode(temp.desc);
        description.appendChild(desctext);
        let price = document.createElement("p");
        let pricetext = document.createTextNode("Price: " + temp.price + " ₺")
        price.appendChild(pricetext)
        let buttondiv = document.createElement("div");
        let addbutton = document.createElement("img");
        addbutton.src = "addbasket.jpeg";
        addbutton.classList.add("addbasketclass")
        addbutton.onclick = addToBasket
        addbutton.style.border="3px solid #958EBD"


        buttondiv.appendChild(addbutton);
        squarre.appendChild(photo);
        squarre.appendChild(divh1);
        squarre.appendChild(description);
        squarre.appendChild(price)
        squarre.appendChild(buttondiv);
        containerr.appendChild(squarre);
        columnn.appendChild(containerr);
        row.appendChild(columnn);

        document.getElementById("name").value = ""
        document.getElementById("price").value = ""
        document.getElementById("desc").value = ""
        document.getElementById("imageurl").value = ""
    }

}
function addToBasket(){
    var parent = event.target.parentElement.parentElement.children;

    let image_url = parent[0].src;
    let name = parent[1].innerHTML;
    let desc = parent[2].innerHTML;
    let price = parent[3].innerHTML;

    let temp = new Cloud(name,desc,price,image_url);

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
        let realproductname = document.createTextNode(basketpro[i].name);
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
        if(basketpro[i].name === product_name){
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
