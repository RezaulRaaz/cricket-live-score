<template>
  <div>
    <div class="body_wrapper">
      <div class="score">
        <h2 class="text-center">Cricket score </h2>
        <div class="score-nav">
          <ul class="wrap-tab">
            <li>
              <a class="score-active">Live & Upcoming</a>
            </li>
            <li><a href="#">Result</a></li>
          </ul>
        </div>
        <div class="scorbody tab-content" style="display: block">
          <div class="score-container">
            <div
              class="d-flex align-items-center justify-content-center p-5"
              v-if="spinner"
            >
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            <!-- live Comonents -->

            <div
              class="score-row"
              v-for="match in liveMatch"
              :key="match.match_id"
            >
              <div class="match-studium-info">
                <div class="match-cotainer">
                  <h5><span class="live">Live</span> {{ match.subtitle }}</h5>
                  <div class="match-time">
                    <p>{{ match.competition.title }}</p>
                    <p>{{matchStart(match.date_start)}} Local Time</p>
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
                      <img
                        style="width: 60px"
                        :src="match.teama.logo_url"
                        alt=""
                      />
                    </div>
                    <h4>VS</h4>
                    <div class="flag-two">
                      <img
                        style="width: 60px"
                        :src="match.teamb.logo_url"
                        alt=""
                      />
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

            <div
              class="score-row"
              v-for="match in Upcoming"
              :key="match.match_id"
            >
              <div class="match-studium-info">
                <div class="match-cotainer">
                  <h5>
                    <span class="upcoming">Upcoming</span> {{ match.subtitle }}
                  </h5>
                  <div class="match-time">
                    <p>{{ match.competition.title }}</p>
                    <p>{{matchStart(match.date_start)}} Local Time</p>
                  </div>
                </div>
              </div>
              <div class="match-team-info">
                <div class="match-cotainer">
                  <h4>{{ match.teama.name }}</h4>
                </div>
              </div>
              <div class="match-team-flag">
                <div class="match-cotainer">
                  <div class="flag">
                    <div class="flag-one">
                      <img
                        style="width: 60px"
                        :src="match.teama.logo_url"
                        alt=""
                      />
                    </div>
                    <h4>VS</h4>
                    <div class="flag-two">
                      <img
                        style="width: 60px"
                        :src="match.teamb.logo_url"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="match-team-info">
                <div class="match-cotainer">
                  <h4>{{ match.teamb.name }}</h4>
                </div>
              </div>
              <div class="match-date">
                <p>{{ momentjs(match.date_start) }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="scorbody tab-content" style="display: none">
          <div class="score-container">
            <div
              class="score-row"
              v-for="match in completed"
              :key="match.match_id"
            >
              <div class="match-team-info">
                <div class="match-cotainer">
                  <h4>{{ match.teama.name }}</h4>
                  <p>{{ match.teama.scores }} ({{ match.teama.overs }})</p>
                </div>
              </div>
              <div class="match-result">
                <div class="match-cotainer">
                  <div class="flag">
                    <div class="flag-one">
                      <img
                        style="width: 60px"
                        :src="match.teama.logo_url"
                        alt=""
                      />
                    </div>
                    <div class="match-result-dtls text-uppercase text-center">
                      <p>{{ match.subtitle }}</p>
                      <p>
                        {{ momentjs(match.date_start)}} -
                        {{momentjs(match.date_end)}}
                      </p>
                      <p>{{ match.status_note }}</p>
                    </div>
                    <div class="flag-two">
                      <img
                        style="width: 60px"
                        :src="match.teamb.logo_url"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="match-team-info">
                <div class="match-cotainer">
                  <h4>{{ match.teamb.name }}</h4>
                  <p>{{ match.teamb.scores }} ({{ match.teamb.overs }})</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "WelcomeComponent",
  props: ["token"],
  data() {
    return {
      liveMatch: [],
      Upcoming: [],
      completed: [],
      moment:'',
      spinner: true,
    };
  },
  mounted() {
    this.getLiveMatch();
    this.getUpcomingMatch();
    this.getCompletedMatch();
    this.momentjs()
  },
  methods: {

    getCompletedMatch() {
      let startDate = moment().subtract(20, 'days').calendar();
      let startDateConvert =moment(startDate).format('YYYY-M-D');
     let EndDate = moment().format('YYYY-M-D');

      var url = `https://rest.entitysport.com/v2/matches?date=${startDateConvert}_${EndDate}&paged=1&per_page=100&token=${this.token}`;
      axios
        .get(url)
        .then((response) => {
          var matches = response.data.response.items;
          matches.map((match) => {
            if (match.status_str == "Completed") {
              this.completed.push(match);
            }
            this.spinner = false;
          });
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    getUpcomingMatch() {
      let EndDate = moment().add(10, 'days').calendar();
      let EndDateConvert =moment(EndDate).format('YYYY-M-D');

     let startDate = moment().format('YYYY-M-D');
      let url = `https://rest.entitysport.com/v2/matches?date=${startDate}_${EndDateConvert}&paged=1&per_page=100&token=${this.token}`;
      axios
        .get(url)
        .then((response) => {
          var matches = response.data.response.items;
          matches.map((match) => {

            if (match.status_str == "Scheduled") {
              this.Upcoming.push(match);
            }
            this.spinner = false;
          });
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    getLiveMatch() {
      let EndDate = moment().add(10, 'days').calendar();
      let EndDateConvert =moment(EndDate).format('YYYY-M-D');
     let startDate = moment().format('YYYY-M-D');
      var url = `https://rest.entitysport.com/v2/matches?date=${startDate}_${EndDateConvert}&paged=1&per_page=100&token=${this.token}`;
      console.log(url);
      axios
        .get(url)
        .then((response) => {
          var matches = response.data.response.items;
          matches.map((match) => {
            if (match.status_str == "Live") {
              this.liveMatch.push(match);
            }
            this.spinner = false;
          });
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    momentjs(date){
       return moment(date).format("MMM Do YY");
    },
    matchStart(time){
        return moment(time).format('LT');
    }
  },
  computed: {},
};
</script>

<style>
</style>
