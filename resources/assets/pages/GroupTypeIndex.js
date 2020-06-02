import React from 'react';
import gql from 'graphql-tag';
import { Link } from 'react-router-dom';
import { useQuery } from '@apollo/react-hooks';

import Empty from '../components/Empty';
import Shell from '../components/utilities/Shell';

const GROUP_TYPE_INDEX_QUERY = gql`
  query GroupTypeIndexQuery {
    groupTypes {
      id
      name
    }
  }
`;

const GroupTypeIndex = () => {
  const title = 'Group types';
  const { loading, error, data } = useQuery(GROUP_TYPE_INDEX_QUERY);

  document.title = title;

  if (error) {
    return <Shell error={error} />;
  }

  if (loading) {
    return <Shell title={title} loading />;
  }

  if (!data.groupTypes) {
    return (
      <Shell title={title}>
        <Empty />
      </Shell>
    );
  }

  return (
    <Shell title={title}>
      <div className="container__block">
        <table className="table">
          <thead>
            <tr>
              <td>Name</td>
            </tr>
          </thead>
          <tbody>
            {data.groupTypes.map(groupType => (
              <tr key={groupType.id}>
                <td>
                  <Link to={`/group-types/${groupType.id}`}>
                    {groupType.name} ({groupType.id})
                  </Link>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </Shell>
  );
};

export default GroupTypeIndex;