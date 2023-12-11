
async function fetchTransaction(transactionId){
    try{
        const response = await fetch(`http://localhost:3000/getTransaction`, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
            },
                body: JSON.stringify({ transactionId }),
        });
        const data     = await response.json();
        
        console.log(data);
        }   catch (error){
        console.error('Error fetching transaction:', error);
    }
}

document.getElementById('fetchButton').addEventListener('click', function(){
    const transactionId = document.getElementById('transactionId').value;

    if(transactionId.trim() !== ''){
        fetchTransaction(transactionId);
        
        // Redirect to the receipt page
        window.location.href = `receipt.php?transactionId=${encodeURIComponent(transactionId)}`;

    } else {
        alert('Please enter a valid Transaction ID.');
    }
});

