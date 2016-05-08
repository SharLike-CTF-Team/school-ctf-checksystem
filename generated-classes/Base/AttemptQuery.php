<?php

namespace Base;

use \Attempt as ChildAttempt;
use \AttemptQuery as ChildAttemptQuery;
use \Exception;
use \PDO;
use Map\AttemptTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'attempt' table.
 *
 *
 *
 * @method     ChildAttemptQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAttemptQuery orderByStatistic_id($order = Criteria::ASC) Order by the statistic_id column
 * @method     ChildAttemptQuery orderByAnswer($order = Criteria::ASC) Order by the answer column
 *
 * @method     ChildAttemptQuery groupById() Group by the id column
 * @method     ChildAttemptQuery groupByStatistic_id() Group by the statistic_id column
 * @method     ChildAttemptQuery groupByAnswer() Group by the answer column
 *
 * @method     ChildAttemptQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAttemptQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAttemptQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAttemptQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAttemptQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAttemptQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAttemptQuery leftJoinStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the Statistic relation
 * @method     ChildAttemptQuery rightJoinStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Statistic relation
 * @method     ChildAttemptQuery innerJoinStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the Statistic relation
 *
 * @method     ChildAttemptQuery joinWithStatistic($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Statistic relation
 *
 * @method     ChildAttemptQuery leftJoinWithStatistic() Adds a LEFT JOIN clause and with to the query using the Statistic relation
 * @method     ChildAttemptQuery rightJoinWithStatistic() Adds a RIGHT JOIN clause and with to the query using the Statistic relation
 * @method     ChildAttemptQuery innerJoinWithStatistic() Adds a INNER JOIN clause and with to the query using the Statistic relation
 *
 * @method     \StatisticQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAttempt findOne(ConnectionInterface $con = null) Return the first ChildAttempt matching the query
 * @method     ChildAttempt findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAttempt matching the query, or a new ChildAttempt object populated from the query conditions when no match is found
 *
 * @method     ChildAttempt findOneById(int $id) Return the first ChildAttempt filtered by the id column
 * @method     ChildAttempt findOneByStatistic_id(int $statistic_id) Return the first ChildAttempt filtered by the statistic_id column
 * @method     ChildAttempt findOneByAnswer(string $answer) Return the first ChildAttempt filtered by the answer column *

 * @method     ChildAttempt requirePk($key, ConnectionInterface $con = null) Return the ChildAttempt by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAttempt requireOne(ConnectionInterface $con = null) Return the first ChildAttempt matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAttempt requireOneById(int $id) Return the first ChildAttempt filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAttempt requireOneByStatistic_id(int $statistic_id) Return the first ChildAttempt filtered by the statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAttempt requireOneByAnswer(string $answer) Return the first ChildAttempt filtered by the answer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAttempt[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAttempt objects based on current ModelCriteria
 * @method     ChildAttempt[]|ObjectCollection findById(int $id) Return ChildAttempt objects filtered by the id column
 * @method     ChildAttempt[]|ObjectCollection findByStatistic_id(int $statistic_id) Return ChildAttempt objects filtered by the statistic_id column
 * @method     ChildAttempt[]|ObjectCollection findByAnswer(string $answer) Return ChildAttempt objects filtered by the answer column
 * @method     ChildAttempt[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AttemptQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AttemptQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'jeopardy', $modelName = '\\Attempt', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAttemptQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAttemptQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAttemptQuery) {
            return $criteria;
        }
        $query = new ChildAttemptQuery();
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
     * @return ChildAttempt|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AttemptTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AttemptTableMap::DATABASE_NAME);
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
     * @return ChildAttempt A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, statistic_id, answer FROM attempt WHERE id = :p0';
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
            /** @var ChildAttempt $obj */
            $obj = new ChildAttempt();
            $obj->hydrate($row);
            AttemptTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAttempt|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AttemptTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AttemptTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AttemptTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AttemptTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AttemptTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the statistic_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStatistic_id(1234); // WHERE statistic_id = 1234
     * $query->filterByStatistic_id(array(12, 34)); // WHERE statistic_id IN (12, 34)
     * $query->filterByStatistic_id(array('min' => 12)); // WHERE statistic_id > 12
     * </code>
     *
     * @see       filterByStatistic()
     *
     * @param     mixed $statistic_id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function filterByStatistic_id($statistic_id = null, $comparison = null)
    {
        if (is_array($statistic_id)) {
            $useMinMax = false;
            if (isset($statistic_id['min'])) {
                $this->addUsingAlias(AttemptTableMap::COL_STATISTIC_ID, $statistic_id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statistic_id['max'])) {
                $this->addUsingAlias(AttemptTableMap::COL_STATISTIC_ID, $statistic_id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AttemptTableMap::COL_STATISTIC_ID, $statistic_id, $comparison);
    }

    /**
     * Filter the query on the answer column
     *
     * Example usage:
     * <code>
     * $query->filterByAnswer('fooValue');   // WHERE answer = 'fooValue'
     * $query->filterByAnswer('%fooValue%'); // WHERE answer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $answer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function filterByAnswer($answer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($answer)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $answer)) {
                $answer = str_replace('*', '%', $answer);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AttemptTableMap::COL_ANSWER, $answer, $comparison);
    }

    /**
     * Filter the query by a related \Statistic object
     *
     * @param \Statistic|ObjectCollection $statistic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAttemptQuery The current query, for fluid interface
     */
    public function filterByStatistic($statistic, $comparison = null)
    {
        if ($statistic instanceof \Statistic) {
            return $this
                ->addUsingAlias(AttemptTableMap::COL_STATISTIC_ID, $statistic->getId(), $comparison);
        } elseif ($statistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AttemptTableMap::COL_STATISTIC_ID, $statistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStatistic() only accepts arguments of type \Statistic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Statistic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function joinStatistic($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Statistic');

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
            $this->addJoinObject($join, 'Statistic');
        }

        return $this;
    }

    /**
     * Use the Statistic relation Statistic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StatisticQuery A secondary query class using the current class as primary query
     */
    public function useStatisticQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStatistic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Statistic', '\StatisticQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAttempt $attempt Object to remove from the list of results
     *
     * @return $this|ChildAttemptQuery The current query, for fluid interface
     */
    public function prune($attempt = null)
    {
        if ($attempt) {
            $this->addUsingAlias(AttemptTableMap::COL_ID, $attempt->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the attempt table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AttemptTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AttemptTableMap::clearInstancePool();
            AttemptTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AttemptTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AttemptTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AttemptTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AttemptTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AttemptQuery
