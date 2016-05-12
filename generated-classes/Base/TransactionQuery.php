<?php

namespace Base;

use \Transaction as ChildTransaction;
use \TransactionQuery as ChildTransactionQuery;
use \Exception;
use \PDO;
use Map\TransactionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'transaction' table.
 *
 *
 *
 * @method     ChildTransactionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTransactionQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildTransactionQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildTransactionQuery orderByPurchasingAgentId($order = Criteria::ASC) Order by the purchasing_agent_id column
 * @method     ChildTransactionQuery orderBySupervisorId($order = Criteria::ASC) Order by the supervisor_id column
 *
 * @method     ChildTransactionQuery groupById() Group by the id column
 * @method     ChildTransactionQuery groupByDescription() Group by the description column
 * @method     ChildTransactionQuery groupByType() Group by the type column
 * @method     ChildTransactionQuery groupByPurchasingAgentId() Group by the purchasing_agent_id column
 * @method     ChildTransactionQuery groupBySupervisorId() Group by the supervisor_id column
 *
 * @method     ChildTransactionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTransactionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTransactionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTransactionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTransactionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTransactionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTransactionQuery leftJoinPurchasingAgent($relationAlias = null) Adds a LEFT JOIN clause to the query using the PurchasingAgent relation
 * @method     ChildTransactionQuery rightJoinPurchasingAgent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PurchasingAgent relation
 * @method     ChildTransactionQuery innerJoinPurchasingAgent($relationAlias = null) Adds a INNER JOIN clause to the query using the PurchasingAgent relation
 *
 * @method     ChildTransactionQuery joinWithPurchasingAgent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PurchasingAgent relation
 *
 * @method     ChildTransactionQuery leftJoinWithPurchasingAgent() Adds a LEFT JOIN clause and with to the query using the PurchasingAgent relation
 * @method     ChildTransactionQuery rightJoinWithPurchasingAgent() Adds a RIGHT JOIN clause and with to the query using the PurchasingAgent relation
 * @method     ChildTransactionQuery innerJoinWithPurchasingAgent() Adds a INNER JOIN clause and with to the query using the PurchasingAgent relation
 *
 * @method     ChildTransactionQuery leftJoinSupervisor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Supervisor relation
 * @method     ChildTransactionQuery rightJoinSupervisor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Supervisor relation
 * @method     ChildTransactionQuery innerJoinSupervisor($relationAlias = null) Adds a INNER JOIN clause to the query using the Supervisor relation
 *
 * @method     ChildTransactionQuery joinWithSupervisor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Supervisor relation
 *
 * @method     ChildTransactionQuery leftJoinWithSupervisor() Adds a LEFT JOIN clause and with to the query using the Supervisor relation
 * @method     ChildTransactionQuery rightJoinWithSupervisor() Adds a RIGHT JOIN clause and with to the query using the Supervisor relation
 * @method     ChildTransactionQuery innerJoinWithSupervisor() Adds a INNER JOIN clause and with to the query using the Supervisor relation
 *
 * @method     ChildTransactionQuery leftJoinPurchase($relationAlias = null) Adds a LEFT JOIN clause to the query using the Purchase relation
 * @method     ChildTransactionQuery rightJoinPurchase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Purchase relation
 * @method     ChildTransactionQuery innerJoinPurchase($relationAlias = null) Adds a INNER JOIN clause to the query using the Purchase relation
 *
 * @method     ChildTransactionQuery joinWithPurchase($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Purchase relation
 *
 * @method     ChildTransactionQuery leftJoinWithPurchase() Adds a LEFT JOIN clause and with to the query using the Purchase relation
 * @method     ChildTransactionQuery rightJoinWithPurchase() Adds a RIGHT JOIN clause and with to the query using the Purchase relation
 * @method     ChildTransactionQuery innerJoinWithPurchase() Adds a INNER JOIN clause and with to the query using the Purchase relation
 *
 * @method     ChildTransactionQuery leftJoinRefund($relationAlias = null) Adds a LEFT JOIN clause to the query using the Refund relation
 * @method     ChildTransactionQuery rightJoinRefund($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Refund relation
 * @method     ChildTransactionQuery innerJoinRefund($relationAlias = null) Adds a INNER JOIN clause to the query using the Refund relation
 *
 * @method     ChildTransactionQuery joinWithRefund($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Refund relation
 *
 * @method     ChildTransactionQuery leftJoinWithRefund() Adds a LEFT JOIN clause and with to the query using the Refund relation
 * @method     ChildTransactionQuery rightJoinWithRefund() Adds a RIGHT JOIN clause and with to the query using the Refund relation
 * @method     ChildTransactionQuery innerJoinWithRefund() Adds a INNER JOIN clause and with to the query using the Refund relation
 *
 * @method     \PurchasingAgentQuery|\SupervisorQuery|\PurchaseQuery|\RefundQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTransaction findOne(ConnectionInterface $con = null) Return the first ChildTransaction matching the query
 * @method     ChildTransaction findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTransaction matching the query, or a new ChildTransaction object populated from the query conditions when no match is found
 *
 * @method     ChildTransaction findOneById(int $id) Return the first ChildTransaction filtered by the id column
 * @method     ChildTransaction findOneByDescription(string $description) Return the first ChildTransaction filtered by the description column
 * @method     ChildTransaction findOneByType(string $type) Return the first ChildTransaction filtered by the type column
 * @method     ChildTransaction findOneByPurchasingAgentId(int $purchasing_agent_id) Return the first ChildTransaction filtered by the purchasing_agent_id column
 * @method     ChildTransaction findOneBySupervisorId(int $supervisor_id) Return the first ChildTransaction filtered by the supervisor_id column *

 * @method     ChildTransaction requirePk($key, ConnectionInterface $con = null) Return the ChildTransaction by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOne(ConnectionInterface $con = null) Return the first ChildTransaction matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransaction requireOneById(int $id) Return the first ChildTransaction filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByDescription(string $description) Return the first ChildTransaction filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByType(string $type) Return the first ChildTransaction filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneByPurchasingAgentId(int $purchasing_agent_id) Return the first ChildTransaction filtered by the purchasing_agent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransaction requireOneBySupervisorId(int $supervisor_id) Return the first ChildTransaction filtered by the supervisor_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransaction[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTransaction objects based on current ModelCriteria
 * @method     ChildTransaction[]|ObjectCollection findById(int $id) Return ChildTransaction objects filtered by the id column
 * @method     ChildTransaction[]|ObjectCollection findByDescription(string $description) Return ChildTransaction objects filtered by the description column
 * @method     ChildTransaction[]|ObjectCollection findByType(string $type) Return ChildTransaction objects filtered by the type column
 * @method     ChildTransaction[]|ObjectCollection findByPurchasingAgentId(int $purchasing_agent_id) Return ChildTransaction objects filtered by the purchasing_agent_id column
 * @method     ChildTransaction[]|ObjectCollection findBySupervisorId(int $supervisor_id) Return ChildTransaction objects filtered by the supervisor_id column
 * @method     ChildTransaction[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TransactionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TransactionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Transaction', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTransactionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTransactionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTransactionQuery) {
            return $criteria;
        }
        $query = new ChildTransactionQuery();
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
     * @return ChildTransaction|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TransactionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TransactionTableMap::DATABASE_NAME);
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
     * @return ChildTransaction A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, description, type, purchasing_agent_id, supervisor_id FROM transaction WHERE id = :p0';
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
            /** @var ChildTransaction $obj */
            $obj = new ChildTransaction();
            $obj->hydrate($row);
            TransactionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTransaction|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TransactionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TransactionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the purchasing_agent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchasingAgentId(1234); // WHERE purchasing_agent_id = 1234
     * $query->filterByPurchasingAgentId(array(12, 34)); // WHERE purchasing_agent_id IN (12, 34)
     * $query->filterByPurchasingAgentId(array('min' => 12)); // WHERE purchasing_agent_id > 12
     * </code>
     *
     * @see       filterByPurchasingAgent()
     *
     * @param     mixed $purchasingAgentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPurchasingAgentId($purchasingAgentId = null, $comparison = null)
    {
        if (is_array($purchasingAgentId)) {
            $useMinMax = false;
            if (isset($purchasingAgentId['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_PURCHASING_AGENT_ID, $purchasingAgentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchasingAgentId['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_PURCHASING_AGENT_ID, $purchasingAgentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_PURCHASING_AGENT_ID, $purchasingAgentId, $comparison);
    }

    /**
     * Filter the query on the supervisor_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySupervisorId(1234); // WHERE supervisor_id = 1234
     * $query->filterBySupervisorId(array(12, 34)); // WHERE supervisor_id IN (12, 34)
     * $query->filterBySupervisorId(array('min' => 12)); // WHERE supervisor_id > 12
     * </code>
     *
     * @see       filterBySupervisor()
     *
     * @param     mixed $supervisorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function filterBySupervisorId($supervisorId = null, $comparison = null)
    {
        if (is_array($supervisorId)) {
            $useMinMax = false;
            if (isset($supervisorId['min'])) {
                $this->addUsingAlias(TransactionTableMap::COL_SUPERVISOR_ID, $supervisorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supervisorId['max'])) {
                $this->addUsingAlias(TransactionTableMap::COL_SUPERVISOR_ID, $supervisorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionTableMap::COL_SUPERVISOR_ID, $supervisorId, $comparison);
    }

    /**
     * Filter the query by a related \PurchasingAgent object
     *
     * @param \PurchasingAgent|ObjectCollection $purchasingAgent The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPurchasingAgent($purchasingAgent, $comparison = null)
    {
        if ($purchasingAgent instanceof \PurchasingAgent) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_PURCHASING_AGENT_ID, $purchasingAgent->getId(), $comparison);
        } elseif ($purchasingAgent instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_PURCHASING_AGENT_ID, $purchasingAgent->toKeyValue('Id', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPurchasingAgent() only accepts arguments of type \PurchasingAgent or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PurchasingAgent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinPurchasingAgent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PurchasingAgent');

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
            $this->addJoinObject($join, 'PurchasingAgent');
        }

        return $this;
    }

    /**
     * Use the PurchasingAgent relation PurchasingAgent object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PurchasingAgentQuery A secondary query class using the current class as primary query
     */
    public function usePurchasingAgentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPurchasingAgent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PurchasingAgent', '\PurchasingAgentQuery');
    }

    /**
     * Filter the query by a related \Supervisor object
     *
     * @param \Supervisor|ObjectCollection $supervisor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterBySupervisor($supervisor, $comparison = null)
    {
        if ($supervisor instanceof \Supervisor) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_SUPERVISOR_ID, $supervisor->getId(), $comparison);
        } elseif ($supervisor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionTableMap::COL_SUPERVISOR_ID, $supervisor->toKeyValue('Id', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySupervisor() only accepts arguments of type \Supervisor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Supervisor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinSupervisor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Supervisor');

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
            $this->addJoinObject($join, 'Supervisor');
        }

        return $this;
    }

    /**
     * Use the Supervisor relation Supervisor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SupervisorQuery A secondary query class using the current class as primary query
     */
    public function useSupervisorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSupervisor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Supervisor', '\SupervisorQuery');
    }

    /**
     * Filter the query by a related \Purchase object
     *
     * @param \Purchase|ObjectCollection $purchase the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByPurchase($purchase, $comparison = null)
    {
        if ($purchase instanceof \Purchase) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_ID, $purchase->getTransactionId(), $comparison);
        } elseif ($purchase instanceof ObjectCollection) {
            return $this
                ->usePurchaseQuery()
                ->filterByPrimaryKeys($purchase->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchase() only accepts arguments of type \Purchase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Purchase relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinPurchase($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Purchase');

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
            $this->addJoinObject($join, 'Purchase');
        }

        return $this;
    }

    /**
     * Use the Purchase relation Purchase object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PurchaseQuery A secondary query class using the current class as primary query
     */
    public function usePurchaseQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPurchase($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Purchase', '\PurchaseQuery');
    }

    /**
     * Filter the query by a related \Refund object
     *
     * @param \Refund|ObjectCollection $refund the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransactionQuery The current query, for fluid interface
     */
    public function filterByRefund($refund, $comparison = null)
    {
        if ($refund instanceof \Refund) {
            return $this
                ->addUsingAlias(TransactionTableMap::COL_ID, $refund->getTransactionId(), $comparison);
        } elseif ($refund instanceof ObjectCollection) {
            return $this
                ->useRefundQuery()
                ->filterByPrimaryKeys($refund->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRefund() only accepts arguments of type \Refund or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Refund relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function joinRefund($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Refund');

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
            $this->addJoinObject($join, 'Refund');
        }

        return $this;
    }

    /**
     * Use the Refund relation Refund object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RefundQuery A secondary query class using the current class as primary query
     */
    public function useRefundQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRefund($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Refund', '\RefundQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTransaction $transaction Object to remove from the list of results
     *
     * @return $this|ChildTransactionQuery The current query, for fluid interface
     */
    public function prune($transaction = null)
    {
        if ($transaction) {
            $this->addUsingAlias(TransactionTableMap::COL_ID, $transaction->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the transaction table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TransactionTableMap::clearInstancePool();
            TransactionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TransactionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TransactionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TransactionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TransactionQuery
