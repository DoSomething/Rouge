import gql from 'graphql-tag';
import React, { useState } from 'react';
import { parse, format } from 'date-fns';
import { useParams } from 'react-router-dom';
import { useQuery } from '@apollo/react-hooks';

import NotFound from './NotFound';
import Action, { ActionFragment } from '../components/Action';
import Shell from '../components/utilities/Shell';
import MetaInformation from '../components/utilities/MetaInformation';

// @TODO: Add support for paging through schoolActionStats once posts with school get reviewed.
const SHOW_ACTION_QUERY = gql`
  query ShowActionQuery($id: Int!) {
    action(id: $id) {
      ...ActionFragment
      schoolActionStats {
        schoolId
        school {
          id
          name
          city
          state
        }
        acceptedQuantity
        updatedAt
      }
    }
  }
  ${ActionFragment}
`;

const ShowAction = () => {
  const { id } = useParams();
  const title = `Action #${id}`;
  document.title = title;

  const { loading, error, data } = useQuery(SHOW_ACTION_QUERY, {
    variables: { id: Number(id) },
  });

  if (error) {
    return <Shell error={error} />;
  }

  if (loading) {
    return <Shell title={title} loading />;
  }

  if (!data.action) {
    return <NotFound title={title} type="action" />;
  }

  const { campaign, name, noun, schoolActionStats, verb } = data.action;

  return (
    <Shell title={title} subtitle={name}>
      <Action action={data.action} isPermalink />
      <ul className="form-actions margin-vertical">
        <li>
          <a className="button -tertiary" href={`/campaigns/${campaign.id}`}>
            View all Actions for Campaign {campaign.internalTitle}
          </a>
        </li>
      </ul>
      {schoolActionStats.length ? (
        <div className="mb-4">
          <h3>School Leaderboard</h3>
          <p className="mb-4">
            These totals are updated any time a Review is created for a Post
            that is associated with this Action and the User's School.
          </p>
          <table className="table">
            <thead>
              <tr>
                <td>School</td>
                <td>Location</td>
                <td className="text-center">
                  Total approved {noun} {verb}
                </td>
              </tr>
            </thead>
            <tbody>
              {schoolActionStats.map(item => (
                <tr key={item.school.id}>
                  <td>
                    <strong>
                      <a href={`/schools/${item.school.id}`}>
                        {item.school.name}
                      </a>
                    </strong>
                  </td>
                  <td>
                    {item.school.city}, {item.school.state}
                  </td>
                  <td className="text-center">
                    <strong>{item.acceptedQuantity}</strong>
                    <div className="text-sm">
                      Updated {format(parse(item.updatedAt), 'M/D/YYYY h:mm a')}
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      ) : null}
    </Shell>
  );
};

export default ShowAction;