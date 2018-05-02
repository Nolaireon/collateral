--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(64) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `password` varchar(80) NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `surname` varchar(32) NULL,
  `patronymic` varchar(32) NULL,
  `sex` varchar(6) NULL,
  `birth_day` DATE NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`),
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`company_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `ITN` varchar(12) NOT NULL,
  `IEC` varchar(9) NULL,
  `PSRN` varchar(15) NOT NULL,
  `settlement_account` varchar(20) NOT NULL,
  `bank_name` varchar(64) NOT NULL,
  `BIC` varchar(9) NOT NULL,
  `correspondent_account` varchar(20) NOT NULL,
  `OKVED` varchar(8) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `owner` varchar(96) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `warehouse_id` int(10) unsigned NOT NULL auto_increment,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `type` varchar(1) NOT NULL,
  `storage_capacity` int(5) NOT NULL,
  `rental_costs` int(5) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`warehouse_id`),
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`company_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_id` int(10) unsigned NOT NULL auto_increment,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`seller_id`),
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`company_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `unit` varchar(2) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(10) unsigned NOT NULL auto_increment,
  `CN` varchar(8) NOT NULL,
  `contract_id` int(10) unsigned NOT NULL,
  `loader_point_id` int(10) unsigned NOT NULL,
  `unloader_point_id` int(10) unsigned NOT NULL,
  `shipper_id` int(10) unsigned NOT NULL,
  `consignee_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `volume` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`delivery_id`),
  UNIQUE KEY `CN` (`CN`),
  FOREIGN KEY (`contract_id`) REFERENCES `contracts`(`contract_id`),
  FOREIGN KEY (`loader_point_id`) REFERENCES `warehouses`(`warehouse_id`),
  FOREIGN KEY (`unloader_point_id`) REFERENCES `warehouses`(`warehouse_id`),
  FOREIGN KEY (`shipper_id`) REFERENCES `clients`(`client_id`),
  FOREIGN KEY (`consignee_id`) REFERENCES `clients`(`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `cash_transaction_id` int(10) unsigned NOT NULL auto_increment,
  `payment_order` int(10) unsigned NOT NULL,
  `contract_id` int(10) unsigned NOT NULL,
  `payer_id` int(10) unsigned NOT NULL,
  `recipient_id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`cash_transaction_id`),
  UNIQUE KEY `payment_order` (`payment_order`),
  FOREIGN KEY (`contract_id`) REFERENCES `contracts`(`contract_id`),
  FOREIGN KEY (`payer_id`) REFERENCES `clients`(`client_id`),
  FOREIGN KEY (`recipient_id`) REFERENCES `clients`(`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `contract_id` int(10) unsigned NOT NULL auto_increment,
  `borrower_id` int(10) unsigned NOT NULL,
  `investor_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `loan_amount` int(10) unsigned NOT NULL,
  `loan_term` int(10) unsigned NOT NULL,
  `volume` int(10) unsigned NOT NULL,
  `value` int(5) unsigned NOT NULL,
  `investor_rate` int(2) unsigned NOT NULL,
  `platform_rate` int(2) unsigned NOT NULL,
  `transactions` int(2) unsigned NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`contract_id`),
  FOREIGN KEY (`borrower_id`) REFERENCES `clients`(`client_id`),
  FOREIGN KEY (`investor_id`) REFERENCES `clients`(`client_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers`(`seller_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
