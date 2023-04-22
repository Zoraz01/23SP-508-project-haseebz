$(document).ready(function () {
    fetchGameData();
  
    function fetchGameData() {
      $.ajax({
        url: "fixtures-action.php",
        type: "POST",
        data: {
          action: "listGames",
        },
        dataType: "json",
        success: function (response) {
          response.data.forEach(function (gameData) {
            console.log(response); 
            createCard(gameData);
          });
        },
      });
    }
  
    function createCard(gameData) {
      var card = `
      <div style = "display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 3rem;">
        <div class="card text-bg-dark text-center mb-4" style="width: 40rem;">
              <div class="card-body">
                  <div class="heading-container">
                  <img src="${gameData[6]}" style="width: 100px; height: 100px;">
                  <h5 class="card-title">${gameData[2]}</h5>
                  <h5 class="card-title">-</h5>
                  <h5 class="card-title">${gameData[4]}</h5>
                  <img src="${gameData[7]}" style="width: 100px; height: 100px;">
                  </div>
                  <div class="paragraph-container">
                  <p class="card-text">${gameData[1]}</p>
                  <p class="card-text">vs</p>
                  <p class="card-text">${gameData[3]}</p>
                  </div>
              </div>
              <div class="card-footer">
                  ${gameData[5]}
              </div>
          </div>
          </div>`;
      $("#game_cards_container").append(card);
    }
  });
  