<template>
  <div>
    <div class="score-row" v-for="match in liveMatch" :key="match.match_id">
      <div class="match-studium-info">
        <div class="match-cotainer">
          <h5><span class="live">Live</span> {{ match.subtitle }}</h5>
          <div class="match-time">
            <p>{{ match.competition.title }}</p>
            <p>{{ matchStart(match.date_start) }} Local Time</p>
          </div>
        </div>
      </div>
      <div class="match-team-info">
        <div class="match-cotainer">
          <h4>{{ match.teama.name }}</h4>
          <p v-if="match.teama.scores_full">
            {{ match.teama.scores_full }}
          </p>
        </div>
      </div>
      <div class="match-team-flag">
        <div class="match-cotainer">
          <div class="flag">
            <div class="flag-one">
              <img style="width: 60px" :src="match.teama.logo_url" alt="" />
            </div>
            <h4>VS</h4>
            <div class="flag-two">
              <img style="width: 60px" :src="match.teamb.logo_url" alt="" />
            </div>
          </div>
        </div>
      </div>
      <div class="match-team-info">
        <div class="match-cotainer">
          <h4>{{ match.teamb.name }}</h4>
          <p v-if="match.teamb.scores_full">
            {{ match.teamb.scores_full }}
          </p>
        </div>
      </div>
      <div class="match-date">
        <p>{{ momentjs(match.date_start) }}</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "LiveComponent",
  props: ["token"],
  data() {
    return {
      liveMatch: [],
      moment: "",
    };
  },
  mounted() {
    this.getLiveMatch();
  },
  methods: {
    getLiveMatch() {
      let EndDate = moment().add(10, "days").calendar();
      let EndDateConvert = moment(EndDate).format("YYYY-M-D");
      let startDate = moment().format("YYYY-M-D");
      var url = `https://rest.entitysport.com/v2/matches?status=3&per_page=100&paged=1&token=${this.token}`;
      console.log(url);
      axios
        .get(url)
        .then((response) => {
          var matches = response.data.response.items;
          matches.map((match) => {
            if (match.status_str == "Live") {
              this.liveMatch.push(match);
            }
          });
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    momentjs(date) {
      return moment(date).format("MMM Do YY");
    },
    matchStart(time) {
      return moment(time).format("LT");
    },
  },
};
</script>
