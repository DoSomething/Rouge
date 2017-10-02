import React from 'react';
import { map, keyBy } from 'lodash';
import SignupCard from '../SignupCard';
import { RestApiClient } from '@dosomething/gateway';
import MetaInformation from '../MetaInformation';
import UserInformation from '../Users/UserInformation';

class UserOverview extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      loading: false,
    },

    this.api = new RestApiClient;
  }

  componentDidMount() {
    this.setState({
      loading: true,
    });

    this.getUserActivity(this.props.user.id)
    .then(() => {
      const ids = map(this.state.signups, 'campaign_id');
      this.getCampaigns(ids);

      this.setState({
        loading: false,
      });
    });
  }

  /**
   * Gets the user activity for the specified user and update state.
   *
   * @param {String} id
   * @return {Object}
   */
  getUserActivity(id) {
    let request = this.api.get('api/v2/activity', {
      filter: {
        northstar_id: id,
      },
      orderBy: 'desc',
      limit: 'all',
    });

    return request.then((result) => {
      this.setState({
        signups: result.data
      });
    });
  }

  /**
   * Gets campaigns associated with signups.
   *
   * @param {Array} ids
   * @return {Object}
   */
  getCampaigns(ids) {
    this.api.get('api/v2/campaigns', {
      ids: ids.join()
    }).then(json => this.setState({
      campaigns: keyBy(json, 'id'),
    }));
  }

  render() {
    const user = this.props.user;

    return (
      <div>
        <div className="container__block">
          <h2 className="heading -emphasized -padded"><span>User Info</span></h2>
        </div>

        <div className="container__block">
          <UserInformation user={user}>
            <MetaInformation title="Meta" details={{
              "Source": user.source,
              "Northstar ID": user.id,
            }} />
          </UserInformation>
        </div>

        <div className="container__block">
          <h2 className="heading -emphasized -padded"><span>Campaigns</span></h2>
        </div>

        <div className="container__block">
          {this.state.loading ?
            <div className="spinner"></div>
          :
            map(this.state.signups, (signup, index) => {
              return <SignupCard key={index} signup={signup} campaign={this.state.campaigns[signup.campaign_id]} />;
            })
          }
        </div>

      </div>
    )
  }
}

export default UserOverview;
