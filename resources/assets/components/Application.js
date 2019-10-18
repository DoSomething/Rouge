import React from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import { ApolloProvider } from '@apollo/react-hooks';

import { env } from '../helpers';
import graphql from '../graphql';
import UserIndex from './UserIndex';
import UserOverview from './UserOverview';

const Application = () => {
  const endpoint = env('GRAPHQL_URL');

  return (
    <ApolloProvider client={graphql(endpoint)}>
      <Router>
        <Switch>
          <Route path="/users" exact>
            <UserIndex />
          </Route>
          <Route path="/users/:id">
            <UserOverview />
          </Route>
        </Switch>
      </Router>
    </ApolloProvider>
  );
};

export default Application;
