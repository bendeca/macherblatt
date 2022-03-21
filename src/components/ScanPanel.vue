<script>
import QrScanner from 'qr-scanner';

export default {

  mounted() {
    this.audio = new Audio('./src/assets/beep.mp3');
    this.scanner = new QrScanner(this.$refs.video, result => this.setResult(result), {
        onDecodeError: error => {
            this.camQrResult = '';
        },
        highlightScanRegion: false,
        highlightCodeOutline: true,
    });
  },
  data() {
    return {
      disableButtons: false,
      camQrResult: '',
      scanner: null,
      audio: null,
      isCheckin: false,
      isCheckout: false,
      showMemberInfo: false, 
      showUserInfo: false,
      showNotActive: false,
      showActions: true,
      blacklistID: 4466,
    }
  },
methods: {
  checkin(event) {
      fetch(
    'https://sheets.googleapis.com/v4/spreadsheets/120gkN9tCt4LyPfj1HqTF29Yu2tr1ue6hTFhfHqSU2FA/values/A1:A100:append',
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
          "range": "A1:B100",
          "values": [
            "a", "b", "c", "d", "e"
          ]
        }
        ),
    })

    // `this` inside methods points to the current active instance
    // this.disableButtons = true;
    // this.isCheckin = true;
    // this.scanner.start();
  },
  checkout(event) {
    // `this` inside methods points to the current active instance
    this.disableButtons = true;
    this.isCheckout = true;
    this.scanner.start();
  },
  setResult(result) {
        // stop scanning for qr codes
        this.scanner.stop();
        // play bleep
        this.audio.play();
        console.log(result.data);
        fetch('https://macherschaft.webling.ch/api/1//member?filter=`Mitgliedsnummer` = "' + result.data + '" AND `Aktives Mitglied` = "true"&format=full&apikey=094ab6eebf91479e8925a9eb38e52cd4')
            .then(response => response.json())
            .then(data => {
                if(data[0]){
                    if(this.isCheckin) {
                        this.showActions = false;
                        this.showMemberInfo;
                        let keys = Object.keys(data[0].properties);
                        let mitgliedart = keys.filter((prop) => prop.startsWith("Mitgliedart"));
                        mitgliedart = mitgliedart.slice(-1)[0];
                        this.camQrResult = 'Hallo ' + data[0].properties.Vorname;
                        console.log(data[0].properties[mitgliedart]);
                    } else {
                        this.$router.push({path: '/checkout', query: {userId: data[0].properties.Mitgliedsnummer }});
                    }
                } else {
                    // member not found
                    this.showActions = false;
                    this.showNotActive;
                }
            });
    },
    reload() {
      this.$router.go();
    }
}}

</script>

<template>
<div class="scan-panel">
    <div class="main">
      <div id="video-container" width="10%">
          <video id="qr-video" ref="video"></video>
      </div>    
      <span id="cam-qr-result">{{ camQrResult }}</span>
      <div class="result-message" v-if="showMemberInfo || showNotActive">
        <div v-if="showMemberInfo">Deine Mitgliedschaft ist aktiv, du kannst nun die Werkstatt nutzen. Bitte melde dich vor verlassen der Macherschaft wieder ab.</div>
        <div v-if="showNotActive">Bitte melde dich bei der Werkstattaufsicht</div>
        <button @click="reload" class="button button-primary button-ok">Ok</button>
      </div>
  </div>
  <div class="actions" v-if="showActions">
      <div>
        <button 
          @click="checkin" 
          class="button button-primary button-check" 
          :disabled="disableButtons">
            Check-In
        </button>
        ich bin gerade gekommen
      </div>
      <div>
      <button 
        @click="checkout" 
        class="button button-primary button-check" 
        :disabled="disableButtons">
          Check-Out
        </button>
        ich bin dann mal weg
      </div>
  </div>
</div>
</template>

<style scoped>
    .main {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-content: center;
        text-align: center;

    }
    .actions {
        height: 500px;
        align-items: baseline;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        text-align: center;
    }

    #video-container {
        position: relative;
        padding-top: 50px;
    }

      .button-check {
        height: 100px;
        line-height: 32px;
        width: 100%;
      }
      #qr-video {
        width: 400px;
        height: 225px;
      }
    #video-container .scan-region-highlight {
        border-radius: 30px;
        outline: rgba(0, 0, 0, .25) solid 50vmax;
    }
    #video-container .code-outline-highlight {
        stroke: rgba(255, 255, 255, .5) !important;
        stroke-width: 15 !important;
        stroke-dasharray: none !important;
    }

    #cam-qr-result {
        font-size: 32px;
        margin: 30px;
    }
    .result-message {
      margin: 30px;
    }
    .button-ok {
      margin: 20px;
      width: 10%;
      height: 40px;
    }

</style>
