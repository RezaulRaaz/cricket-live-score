<template>
  <div>
    <div
      class="d-flex align-items-center justify-content-center p-5"
      v-if="spinner"
    >
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="score-row" v-for="match in Upcoming" :key="match.match_id">
      <div class="match-studium-info">
        <div class="match-cotainer">
          <h5><span class="upcoming">Upcoming</span> {{ match.subtitle }}</h5>
          <div class="match-time">
            <p>{{ match.competition.title }}</p>
            <p>{{ matchStart(match.date_start) }} Local Time</p>
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
        </div>
      </div>
      <div class="match-date">
        <p>{{ momentjs(match.date_start) }}</p>
      </div>
    </div>

<!-- mobile version -->
        <div class="mobile-row" v-for="match in Upcoming" :key="match.match_id" >
            <div class="mobile-match-info">
            <h5><span style="background-color: green" >Upcoming</span> {{ match.subtitle }}</h5>
            <p class="m-live">
              {{match.competition.title }}
            </p>
            <p>{{ matchStart(match.date_start) }} Local Time</p>
            </div>
            <div class="mobile-team">
                <div class="mobile-team-a">
                <h5 class="p-3">
                   {{ match.teama.name }}
                </h5>

                </div>
                <div class="mobile-team-a-flag">
                <img :src="match.teama.logo_url" alt="" style="width: 40px;">
                </div>
                <span>VS</span>
                <div class="mobile-team-b-flag">
                <img :src="match.teamb.logo_url" alt="" style="width: 40px;">
                </div>
                <div class="mobile-team-b">
                <h5 class="p-3">
                   {{ match.teamb.name }}
                </h5>
                </div>
            </div>
            <p class="text-center" >
               {{ momentjs(match.date_start) }}
            </p>
        </div>

  </div>
</template>
<script>
export default {
  name: "UpcomingComponent",
  props: ["token"],
  data() {
    return {
      Upcoming: [],
      spinner: true,
    };
  },
  mounted() {
    this.getUpcomingMatch();
  },
  methods: {
    getUpcomingMatch() {
      let url = `https://rest.entitysport.com/v2/matches?status=1&per_page=100&paged=1&token=${this.token}`;
      axios
        .get(url)
        .then((response) => {
          var matches = response.data.response.items;
          matches.map((match) => {
            if (match.status_str == "Scheduled") {
              this.Upcoming.push(match);
            }
          });
          this.spinner = false;
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
