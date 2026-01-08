<style>
    .about-header {
    width: 30%;
    display: flex;
    align-items:center;
    background-color: red;
}

.about-header hr{
    width: 70px;
    border-width: 2px;
    margin-left: 0;
}

.about-header h4{
    font-size: 30px;
    font-weight: 500;
    text-transform: capitalize;
    background-color: blue;
    margin-left: 0;
    text-align: left;
    float: left;
}
</style>

<form method="post" action="{{ Route('debugger',['State'=>'test']) }}" accept-charset="UTF-8">
    @csrf
    
    <label for="listItem">New Todo Item</label><br>
    <input type="text" name="listItem">
    <button type="submit">Save item</button>
</form>

