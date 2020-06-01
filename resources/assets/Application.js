import React from 'react';
import { BrowserRouter, Route, Switch, Redirect } from 'react-router-dom';
import { ApolloProvider } from '@apollo/react-hooks';

import { env } from './helpers';
import graphql from './graphql';
import ShowPost from './pages/ShowPost';
import ShowUser from './pages/ShowUser';
import UserIndex from './pages/UserIndex';
import ShowAction from './pages/ShowAction';
import ShowSignup from './pages/ShowSignup';
import ShowSchool from './pages/ShowSchool';
import ShowCampaign from './pages/ShowCampaign';
import ShowGroupType from './pages/ShowGroupType';
import CampaignIndex from './pages/CampaignIndex';
import GroupTypeIndex from './pages/GroupTypeIndex';

const Application = () => {
  const endpoint = env('GRAPHQL_URL');

  return (
    <ApolloProvider client={graphql(endpoint)}>
      <BrowserRouter>
        <Switch>
          <Route path="/actions/:id">
            <ShowAction />
          </Route>
          <Route path="/campaigns" exact>
            <CampaignIndex isOpen={true} />
          </Route>
          <Route path="/campaigns/closed" exact>
            <CampaignIndex isOpen={false} />
          </Route>
          <Route path="/campaigns/:id" exact>
            <ShowCampaign />
          </Route>
          <Redirect from="/campaigns/:id/inbox" to="/campaigns/:id/pending" />
          <Route path="/campaigns/:id/:status">
            <ShowCampaign />
          </Route>
          <Route path="/group-types" exact>
            <GroupTypeIndex />
          </Route>
          <Route path="/group-types/:id">
            <ShowGroupType />
          </Route>
          <Route path="/users" exact>
            <UserIndex />
          </Route>
          <Route path="/users/:id/referrals" exact>
            <ShowUser selectedTab="referrals" />
          </Route>
          <Route path="/users/:id">
            <ShowUser />
          </Route>
          <Route path="/posts/:id">
            <ShowPost />
          </Route>
          <Route path="/signups/:id">
            <ShowSignup />
          </Route>
          <Route path="/schools/:id">
            <ShowSchool />
          </Route>
        </Switch>
      </BrowserRouter>
    </ApolloProvider>
  );
};

export default Application;
