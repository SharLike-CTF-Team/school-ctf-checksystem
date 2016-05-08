<?php

namespace Base;

use \Statistic as ChildStatistic;
use \StatisticQuery as ChildStatisticQuery;
use \Exception;
use \PDO;
use Map\StatisticTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'statistic' table.
 *
 *
 *
 * @method     ChildStatisticQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStatisticQuery orderByTeamId($order = Criteria::ASC) Order by the team_id column
 * @method     ChildStatisticQuery orderByTaskId($order = Criteria::ASC) Order by the task_id column
 * @method     ChildStatisticQuery orderByFlagDone($order = Criteria::ASC) Order by the flag_done column
 * @method     ChildStatisticQuery orderByTimeDone($order = Criteria::ASC) Order by the time_done column
 *
 * @method     ChildStatisticQuery groupById() Group by the id column
 * @method     ChildStatisticQuery groupByTeamId() Group by the team_id column
 * @method     ChildStatisticQuery groupByTaskId() Group by the task_id column
 * @method     ChildStatisticQuery groupByFlagDone() Group by the flag_done column
 * @method     ChildStatisticQuery groupByTimeDone() Group by the time_done column
 *
 * @method     ChildStatisticQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStatisticQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStatisticQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStatisticQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildStatisticQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildStatisticQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildStatisticQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildStatisticQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildStatisticQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildStatisticQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildStatisticQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildStatisticQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildStatisticQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     ChildStatisticQuery leftJoinTask($relationAlias = null) Adds a LEFT JOIN clause to the query using the Task relation
 * @method     ChildStatisticQuery rightJoinTask($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Task relation
 * @method     ChildStatisticQuery innerJoinTask($relationAlias = null) Adds a INNER JOIN clause to the query using the Task relation
 *
 * @method     ChildStatisticQuery joinWithTask($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Task relation
 *
 * @method     ChildStatisticQuery leftJoinWithTask() Adds a LEFT JOIN clause and with to the query using the Task relation
 * @method     ChildStatisticQuery rightJoinWithTask() Adds a RIGHT JOIN clause and with to the query using the Task relation
 * @method     ChildStatisticQuery innerJoinWithTask() Adds a INNER JOIN clause and with to the query using the Task relation
 *
 * @method     ChildStatisticQuery leftJoinAttempt($relationAlias = null) Adds a LEFT JOIN clause to the query using the Attempt relation
 * @method     ChildStatisticQuery rightJoinAttempt($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Attempt relation
 * @method     ChildStatisticQuery innerJoinAttempt($relationAlias = null) Adds a INNER JOIN clause to the query using the Attempt relation
 *
 * @method     ChildStatisticQuery joinWithAttempt($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Attempt relation
 *
 * @method     ChildStatisticQuery leftJoinWithAttempt() Adds a LEFT JOIN clause and with to the query using the Attempt relation
 * @method     ChildStatisticQuery rightJoinWithAttempt() Adds a RIGHT JOIN clause and with to the query using the Attempt relation
 * @method     ChildStatisticQuery innerJoinWithAttempt() Adds a INNER JOIN clause and with to the query using the Attempt relation
 *
 * @method     \TeamQuery|\TaskQuery|\AttemptQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStatistic findOne(ConnectionInterface $con = null) Return the first ChildStatistic matching the query
 * @method     ChildStatistic findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStatistic matching the query, or a new ChildStatistic object populated from the query conditions when no match is found
 *
 * @method     ChildStatistic findOneById(int $id) Return the first ChildStatistic filtered by the id column
 * @method     ChildStatistic findOneByTeamId(int $team_id) Return the first ChildStatistic filtered by the team_id column
 * @method     ChildStatistic findOneByTaskId(int $task_id) Return the first ChildStatistic filtered by the task_id column
 * @method     ChildStatistic findOneByFlagDone(boolean $flag_done) Return the first ChildStatistic filtered by the flag_done column
 * @method     ChildStatistic findOneByTimeDone(string $time_done) Return the first ChildStatistic filtered by the time_done column *

 * @method     ChildStatistic requirePk($key, ConnectionInterface $con = null) Return the ChildStatistic by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStatistic requireOne(ConnectionInterface $con = null) Return the first ChildStatistic matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStatistic requireOneById(int $id) Return the first ChildStatistic filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStatistic requireOneByTeamId(int $team_id) Return the first ChildStatistic filtered by the team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStatistic requireOneByTaskId(int $task_id) Return the first ChildStatistic filtered by the task_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStatistic requireOneByFlagDone(boolean $flag_done) Return the first ChildStatistic filtered by the flag_done column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStatistic requireOneByTimeDone(string $time_done) Return the first ChildStatistic filtered by the time_done column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStatistic[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStatistic objects based on current ModelCriteria
 * @method     ChildStatistic[]|ObjectCollection findById(int $id) Return ChildStatistic objects filtered by the id column
 * @method     ChildStatistic[]|ObjectCollection findByTeamId(int $team_id) Return ChildStatistic objects filtered by the team_id column
 * @method     ChildStatistic[]|ObjectCollection findByTaskId(int $task_id) Return ChildStatistic objects filtered by the task_id column
 * @method     ChildStatistic[]|ObjectCollection findByFlagDone(boolean $flag_done) Return ChildStatistic objects filtered by the flag_done column
 * @method     ChildStatistic[]|ObjectCollection findByTimeDone(string $time_done) Return ChildStatistic objects filtered by the time_done column
 * @method     ChildStatistic[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StatisticQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\StatisticQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'jeopardy', $modelName = '\\Statistic', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStatisticQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStatisticQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStatisticQuery) {
            return $criteria;
        }
        $query = new ChildStatisticQuery();
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
     * @return ChildStatistic|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StatisticTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StatisticTableMap::DATABASE_NAME);
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
     * @return ChildStatistic A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, team_id, task_id, flag_done, time_done FROM statistic WHERE id = :p0';
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
            /** @var ChildStatistic $obj */
            $obj = new ChildStatistic();
            $obj->hydrate($row);
            StatisticTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStatistic|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StatisticTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StatisticTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StatisticTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StatisticTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StatisticTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(StatisticTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(StatisticTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StatisticTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Filter the query on the task_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTaskId(1234); // WHERE task_id = 1234
     * $query->filterByTaskId(array(12, 34)); // WHERE task_id IN (12, 34)
     * $query->filterByTaskId(array('min' => 12)); // WHERE task_id > 12
     * </code>
     *
     * @see       filterByTask()
     *
     * @param     mixed $taskId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByTaskId($taskId = null, $comparison = null)
    {
        if (is_array($taskId)) {
            $useMinMax = false;
            if (isset($taskId['min'])) {
                $this->addUsingAlias(StatisticTableMap::COL_TASK_ID, $taskId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($taskId['max'])) {
                $this->addUsingAlias(StatisticTableMap::COL_TASK_ID, $taskId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StatisticTableMap::COL_TASK_ID, $taskId, $comparison);
    }

    /**
     * Filter the query on the flag_done column
     *
     * Example usage:
     * <code>
     * $query->filterByFlagDone(true); // WHERE flag_done = true
     * $query->filterByFlagDone('yes'); // WHERE flag_done = true
     * </code>
     *
     * @param     boolean|string $flagDone The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByFlagDone($flagDone = null, $comparison = null)
    {
        if (is_string($flagDone)) {
            $flagDone = in_array(strtolower($flagDone), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StatisticTableMap::COL_FLAG_DONE, $flagDone, $comparison);
    }

    /**
     * Filter the query on the time_done column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeDone('2011-03-14'); // WHERE time_done = '2011-03-14'
     * $query->filterByTimeDone('now'); // WHERE time_done = '2011-03-14'
     * $query->filterByTimeDone(array('max' => 'yesterday')); // WHERE time_done > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeDone The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByTimeDone($timeDone = null, $comparison = null)
    {
        if (is_array($timeDone)) {
            $useMinMax = false;
            if (isset($timeDone['min'])) {
                $this->addUsingAlias(StatisticTableMap::COL_TIME_DONE, $timeDone['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeDone['max'])) {
                $this->addUsingAlias(StatisticTableMap::COL_TIME_DONE, $timeDone['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StatisticTableMap::COL_TIME_DONE, $timeDone, $comparison);
    }

    /**
     * Filter the query by a related \Team object
     *
     * @param \Team|ObjectCollection $team The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByTeam($team, $comparison = null)
    {
        if ($team instanceof \Team) {
            return $this
                ->addUsingAlias(StatisticTableMap::COL_TEAM_ID, $team->getId(), $comparison);
        } elseif ($team instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StatisticTableMap::COL_TEAM_ID, $team->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStatisticQuery The current query, for fluid interface
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
     * Filter the query by a related \Task object
     *
     * @param \Task|ObjectCollection $task The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByTask($task, $comparison = null)
    {
        if ($task instanceof \Task) {
            return $this
                ->addUsingAlias(StatisticTableMap::COL_TASK_ID, $task->getId(), $comparison);
        } elseif ($task instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StatisticTableMap::COL_TASK_ID, $task->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTask() only accepts arguments of type \Task or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Task relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function joinTask($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Task');

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
            $this->addJoinObject($join, 'Task');
        }

        return $this;
    }

    /**
     * Use the Task relation Task object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TaskQuery A secondary query class using the current class as primary query
     */
    public function useTaskQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTask($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Task', '\TaskQuery');
    }

    /**
     * Filter the query by a related \Attempt object
     *
     * @param \Attempt|ObjectCollection $attempt the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStatisticQuery The current query, for fluid interface
     */
    public function filterByAttempt($attempt, $comparison = null)
    {
        if ($attempt instanceof \Attempt) {
            return $this
                ->addUsingAlias(StatisticTableMap::COL_ID, $attempt->getStatistic_id(), $comparison);
        } elseif ($attempt instanceof ObjectCollection) {
            return $this
                ->useAttemptQuery()
                ->filterByPrimaryKeys($attempt->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAttempt() only accepts arguments of type \Attempt or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Attempt relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function joinAttempt($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Attempt');

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
            $this->addJoinObject($join, 'Attempt');
        }

        return $this;
    }

    /**
     * Use the Attempt relation Attempt object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AttemptQuery A secondary query class using the current class as primary query
     */
    public function useAttemptQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAttempt($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Attempt', '\AttemptQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStatistic $statistic Object to remove from the list of results
     *
     * @return $this|ChildStatisticQuery The current query, for fluid interface
     */
    public function prune($statistic = null)
    {
        if ($statistic) {
            $this->addUsingAlias(StatisticTableMap::COL_ID, $statistic->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the statistic table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StatisticTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StatisticTableMap::clearInstancePool();
            StatisticTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StatisticTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StatisticTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StatisticTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StatisticTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StatisticQuery
