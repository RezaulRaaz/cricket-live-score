<template>
  <div>
    <div class="score-row" v-for="match in completed" :key="match.match_id">
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
              <img style="width: 60px" :src="match.teama.logo_url" alt="" />
            </div>
            <div class="match-result-dtls text-uppercase text-center">
              <p>{{ match.subtitle }}</p>
              <p>
                {{ momentjs(match.date_start) }} -
                {{ momentjs(match.date_end) }}
              </p>
              <p>{{ match.status_note }}</p>
            </div>
            <div class="flag-two">
              <img style="width: 60px" :src="match.teamb.logo_url" alt="" />
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
    <!-- mobile version -->
        <div class="mobile-row" v-for="match in completed" :key="match.match_id" >
            <div class="mobile-match-info">
            <p class="m-live">
               {{ match.status_note }}
                </p>
            </div>
            <div class="mobile-team">
                <div class="mobile-team-a">
                <h5>
                   {{ match.teama.name }}
                </h5>
                <p>
                    {{ match.teama.scores }} ({{ match.teama.overs }})
                </p>
                </div>
                <div class="mobile-team-a-flag">
                <img :src="match.teama.logo_url" alt="" style="width: 40px;">
                </div>
                <span>VS</span>
                <div class="mobile-team-b-flag">
                <img :src="match.teamb.logo_url" alt="" style="width: 40px;">
                </div>
                <div class="mobile-team-b">
                <h5>
                   {{ match.teamb.name }}
                </h5>
                <p>
                    {{ match.teamb.scores }} ({{ match.teamb.overs }})
                </p>
                </div>

            </div>
            <p class="text-center">
                 {{ momentjs(match.date_start) }} -
                {{ momentjs(match.date_end) }}
                </p>
        </div>
  </div>
</template>
<script>
export default {
  name: "CompleteComponents",
  props: ["token"],
  data() {
    return {
      completed: [],
      moment: "",
      spinner: true,
    };
  },
  mounted() {
    this.getCompletedMatch();
  },
  methods: {
    getCompletedMatch() {
      var url = `https://rest.entitysport.com/v2/matches?status=2&per_page=100&paged=1&token=${this.token}`;
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
    momentjs(date) {
      return moment(date).format("MMM Do YY");
    },
    matchStart(time) {
      return moment(time).format("LT");
    },
  },
};
</script>
