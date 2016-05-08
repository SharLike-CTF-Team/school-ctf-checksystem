<?php

namespace Base;

use \Scoreboard as ChildScoreboard;
use \ScoreboardQuery as ChildScoreboardQuery;
use \Exception;
use \PDO;
use Map\ScoreboardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'scoreboard' table.
 *
 *
 *
 * @method     ChildScoreboardQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildScoreboardQuery orderByTeamId($order = Criteria::ASC) Order by the team_id column
 * @method     ChildScoreboardQuery orderByFullPoints($order = Criteria::ASC) Order by the full_points column
 *
 * @method     ChildScoreboardQuery groupById() Group by the id column
 * @method     ChildScoreboardQuery groupByTeamId() Group by the team_id column
 * @method     ChildScoreboardQuery groupByFullPoints() Group by the full_points column
 *
 * @method     ChildScoreboardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildScoreboardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildScoreboardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildScoreboardQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildScoreboardQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildScoreboardQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildScoreboardQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildScoreboardQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildScoreboardQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildScoreboardQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildScoreboardQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildScoreboardQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildScoreboardQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     \TeamQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildScoreboard findOne(ConnectionInterface $con = null) Return the first ChildScoreboard matching the query
 * @method     ChildScoreboard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildScoreboard matching the query, or a new ChildScoreboard object populated from the query conditions when no match is found
 *
 * @method     ChildScoreboard findOneById(int $id) Return the first ChildScoreboard filtered by the id column
 * @method     ChildScoreboard findOneByTeamId(int $team_id) Return the first ChildScoreboard filtered by the team_id column
 * @method     ChildScoreboard findOneByFullPoints(int $full_points) Return the first ChildScoreboard filtered by the full_points column *

 * @method     ChildScoreboard requirePk($key, ConnectionInterface $con = null) Return the ChildScoreboard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScoreboard requireOne(ConnectionInterface $con = null) Return the first ChildScoreboard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildScoreboard requireOneById(int $id) Return the first ChildScoreboard filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScoreboard requireOneByTeamId(int $team_id) Return the first ChildScoreboard filtered by the team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScoreboard requireOneByFullPoints(int $full_points) Return the first ChildScoreboard filtered by the full_points column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildScoreboard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildScoreboard objects based on current ModelCriteria
 * @method     ChildScoreboard[]|ObjectCollection findById(int $id) Return ChildScoreboard objects filtered by the id column
 * @method     ChildScoreboard[]|ObjectCollection findByTeamId(int $team_id) Return ChildScoreboard objects filtered by the team_id column
 * @method     ChildScoreboard[]|ObjectCollection findByFullPoints(int $full_points) Return ChildScoreboard objects filtered by the full_points column
 * @method     ChildScoreboard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ScoreboardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ScoreboardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'jeopardy', $modelName = '\\Scoreboard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildScoreboardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildScoreboardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildScoreboardQuery) {
            return $criteria;
        }
        $query = new ChildScoreboardQuery();
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
     * @return ChildScoreboard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ScoreboardTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ScoreboardTableMap::DATABASE_NAME);
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
     * @return ChildScoreboard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, team_id, full_points FROM scoreboard WHERE id = :p0';
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
            /** @var ChildScoreboard $obj */
            $obj = new ChildScoreboard();
            $obj->hydrate($row);
            ScoreboardTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildScoreboard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ScoreboardTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ScoreboardTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ScoreboardTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ScoreboardTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreboardTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the team_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeamId(1234); // WHERE team_id = 1234
     * $query->filterByTeamId(array(12, 34)); // WHERE team_id IN (12, 34)
     * $query->filterByTeamId(array('min' => 12)); // WHERE team_id > 12
     * </code>
     *
     * @see       filterByTeam()
     *
     * @param     mixed $teamId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(ScoreboardTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(ScoreboardTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreboardTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Filter the query on the full_points column
     *
     * Example usage:
     * <code>
     * $query->filterByFullPoints(1234); // WHERE full_points = 1234
     * $query->filterByFullPoints(array(12, 34)); // WHERE full_points IN (12, 34)
     * $query->filterByFullPoints(array('min' => 12)); // WHERE full_points > 12
     * </code>
     *
     * @param     mixed $fullPoints The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
     */
    public function filterByFullPoints($fullPoints = null, $comparison = null)
    {
        if (is_array($fullPoints)) {
            $useMinMax = false;
            if (isset($fullPoints['min'])) {
                $this->addUsingAlias(ScoreboardTableMap::COL_FULL_POINTS, $fullPoints['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fullPoints['max'])) {
                $this->addUsingAlias(ScoreboardTableMap::COL_FULL_POINTS, $fullPoints['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreboardTableMap::COL_FULL_POINTS, $fullPoints, $comparison);
    }

    /**
     * Filter the query by a related \Team object
     *
     * @param \Team|ObjectCollection $team The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildScoreboardQuery The current query, for fluid interface
     */
    public function filterByTeam($team, $comparison = null)
    {
        if ($team instanceof \Team) {
            return $this
                ->addUsingAlias(ScoreboardTableMap::COL_TEAM_ID, $team->getId(), $comparison);
        } elseif ($team instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ScoreboardTableMap::COL_TEAM_ID, $team->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
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
     * @param   ChildScoreboard $scoreboard Object to remove from the list of results
     *
     * @return $this|ChildScoreboardQuery The current query, for fluid interface
     */
    public function prune($scoreboard = null)
    {
        if ($scoreboard) {
            $this->addUsingAlias(ScoreboardTableMap::COL_ID, $scoreboard->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the scoreboard table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScoreboardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ScoreboardTableMap::clearInstancePool();
            ScoreboardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ScoreboardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ScoreboardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ScoreboardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ScoreboardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ScoreboardQuery
