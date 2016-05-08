<?php

namespace Base;

use \Participants as ChildParticipants;
use \ParticipantsQuery as ChildParticipantsQuery;
use \Exception;
use \PDO;
use Map\ParticipantsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'participants' table.
 *
 *
 *
 * @method     ChildParticipantsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildParticipantsQuery orderByTeam_id($order = Criteria::ASC) Order by the team_id column
 * @method     ChildParticipantsQuery orderByPass($order = Criteria::ASC) Order by the pass column
 * @method     ChildParticipantsQuery orderBySecretkey($order = Criteria::ASC) Order by the secretkey column
 * @method     ChildParticipantsQuery orderById_pass($order = Criteria::ASC) Order by the id_pass column
 * @method     ChildParticipantsQuery orderByIp($order = Criteria::ASC) Order by the ip column
 *
 * @method     ChildParticipantsQuery groupById() Group by the id column
 * @method     ChildParticipantsQuery groupByTeam_id() Group by the team_id column
 * @method     ChildParticipantsQuery groupByPass() Group by the pass column
 * @method     ChildParticipantsQuery groupBySecretkey() Group by the secretkey column
 * @method     ChildParticipantsQuery groupById_pass() Group by the id_pass column
 * @method     ChildParticipantsQuery groupByIp() Group by the ip column
 *
 * @method     ChildParticipantsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildParticipantsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildParticipantsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildParticipantsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildParticipantsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildParticipantsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildParticipantsQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildParticipantsQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildParticipantsQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildParticipantsQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildParticipantsQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildParticipantsQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildParticipantsQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     \TeamQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildParticipants findOne(ConnectionInterface $con = null) Return the first ChildParticipants matching the query
 * @method     ChildParticipants findOneOrCreate(ConnectionInterface $con = null) Return the first ChildParticipants matching the query, or a new ChildParticipants object populated from the query conditions when no match is found
 *
 * @method     ChildParticipants findOneById(int $id) Return the first ChildParticipants filtered by the id column
 * @method     ChildParticipants findOneByTeam_id(int $team_id) Return the first ChildParticipants filtered by the team_id column
 * @method     ChildParticipants findOneByPass(string $pass) Return the first ChildParticipants filtered by the pass column
 * @method     ChildParticipants findOneBySecretkey(string $secretkey) Return the first ChildParticipants filtered by the secretkey column
 * @method     ChildParticipants findOneById_pass(string $id_pass) Return the first ChildParticipants filtered by the id_pass column
 * @method     ChildParticipants findOneByIp(string $ip) Return the first ChildParticipants filtered by the ip column *

 * @method     ChildParticipants requirePk($key, ConnectionInterface $con = null) Return the ChildParticipants by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipants requireOne(ConnectionInterface $con = null) Return the first ChildParticipants matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipants requireOneById(int $id) Return the first ChildParticipants filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipants requireOneByTeam_id(int $team_id) Return the first ChildParticipants filtered by the team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipants requireOneByPass(string $pass) Return the first ChildParticipants filtered by the pass column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipants requireOneBySecretkey(string $secretkey) Return the first ChildParticipants filtered by the secretkey column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipants requireOneById_pass(string $id_pass) Return the first ChildParticipants filtered by the id_pass column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipants requireOneByIp(string $ip) Return the first ChildParticipants filtered by the ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipants[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildParticipants objects based on current ModelCriteria
 * @method     ChildParticipants[]|ObjectCollection findById(int $id) Return ChildParticipants objects filtered by the id column
 * @method     ChildParticipants[]|ObjectCollection findByTeam_id(int $team_id) Return ChildParticipants objects filtered by the team_id column
 * @method     ChildParticipants[]|ObjectCollection findByPass(string $pass) Return ChildParticipants objects filtered by the pass column
 * @method     ChildParticipants[]|ObjectCollection findBySecretkey(string $secretkey) Return ChildParticipants objects filtered by the secretkey column
 * @method     ChildParticipants[]|ObjectCollection findById_pass(string $id_pass) Return ChildParticipants objects filtered by the id_pass column
 * @method     ChildParticipants[]|ObjectCollection findByIp(string $ip) Return ChildParticipants objects filtered by the ip column
 * @method     ChildParticipants[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ParticipantsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ParticipantsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'jeopardy', $modelName = '\\Participants', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildParticipantsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildParticipantsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildParticipantsQuery) {
            return $criteria;
        }
        $query = new ChildParticipantsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildParticipants|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ParticipantsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ParticipantsTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipants A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, team_id, pass, secretkey, id_pass, ip FROM participants WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildParticipants $obj */
            $obj = new ChildParticipants();
            $obj->hydrate($row);
            ParticipantsTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildParticipants|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ParticipantsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ParticipantsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ParticipantsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ParticipantsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the team_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam_id(1234); // WHERE team_id = 1234
     * $query->filterByTeam_id(array(12, 34)); // WHERE team_id IN (12, 34)
     * $query->filterByTeam_id(array('min' => 12)); // WHERE team_id > 12
     * </code>
     *
     * @see       filterByTeam()
     *
     * @param     mixed $team_id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterByTeam_id($team_id = null, $comparison = null)
    {
        if (is_array($team_id)) {
            $useMinMax = false;
            if (isset($team_id['min'])) {
                $this->addUsingAlias(ParticipantsTableMap::COL_TEAM_ID, $team_id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($team_id['max'])) {
                $this->addUsingAlias(ParticipantsTableMap::COL_TEAM_ID, $team_id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantsTableMap::COL_TEAM_ID, $team_id, $comparison);
    }

    /**
     * Filter the query on the pass column
     *
     * Example usage:
     * <code>
     * $query->filterByPass('fooValue');   // WHERE pass = 'fooValue'
     * $query->filterByPass('%fooValue%'); // WHERE pass LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterByPass($pass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pass)) {
                $pass = str_replace('*', '%', $pass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipantsTableMap::COL_PASS, $pass, $comparison);
    }

    /**
     * Filter the query on the secretkey column
     *
     * Example usage:
     * <code>
     * $query->filterBySecretkey('fooValue');   // WHERE secretkey = 'fooValue'
     * $query->filterBySecretkey('%fooValue%'); // WHERE secretkey LIKE '%fooValue%'
     * </code>
     *
     * @param     string $secretkey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterBySecretkey($secretkey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($secretkey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $secretkey)) {
                $secretkey = str_replace('*', '%', $secretkey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipantsTableMap::COL_SECRETKEY, $secretkey, $comparison);
    }

    /**
     * Filter the query on the id_pass column
     *
     * Example usage:
     * <code>
     * $query->filterById_pass('fooValue');   // WHERE id_pass = 'fooValue'
     * $query->filterById_pass('%fooValue%'); // WHERE id_pass LIKE '%fooValue%'
     * </code>
     *
     * @param     string $id_pass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterById_pass($id_pass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id_pass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $id_pass)) {
                $id_pass = str_replace('*', '%', $id_pass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipantsTableMap::COL_ID_PASS, $id_pass, $comparison);
    }

    /**
     * Filter the query on the ip column
     *
     * Example usage:
     * <code>
     * $query->filterByIp('fooValue');   // WHERE ip = 'fooValue'
     * $query->filterByIp('%fooValue%'); // WHERE ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterByIp($ip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ip)) {
                $ip = str_replace('*', '%', $ip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ParticipantsTableMap::COL_IP, $ip, $comparison);
    }

    /**
     * Filter the query by a related \Team object
     *
     * @param \Team|ObjectCollection $team The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipantsQuery The current query, for fluid interface
     */
    public function filterByTeam($team, $comparison = null)
    {
        if ($team instanceof \Team) {
            return $this
                ->addUsingAlias(ParticipantsTableMap::COL_TEAM_ID, $team->getId(), $comparison);
        } elseif ($team instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipantsTableMap::COL_TEAM_ID, $team->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTeam() only accepts arguments of type \Team or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Team relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function joinTeam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Team');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Team');
        }

        return $this;
    }

    /**
     * Use the Team relation Team object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeamQuery A secondary query class using the current class as primary query
     */
    public function useTeamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTeam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Team', '\TeamQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildParticipants $participants Object to remove from the list of results
     *
     * @return $this|ChildParticipantsQuery The current query, for fluid interface
     */
    public function prune($participants = null)
    {
        if ($participants) {
            $this->addUsingAlias(ParticipantsTableMap::COL_ID, $participants->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the participants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ParticipantsTableMap::clearInstancePool();
            ParticipantsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ParticipantsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ParticipantsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ParticipantsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ParticipantsQuery
