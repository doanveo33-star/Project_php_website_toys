-- Fix orders table structure for ToyShop
-- Run this if VNPay is not working

-- Add missing columns to orders table if they don't exist
ALTER TABLE orders 
ADD COLUMN IF NOT EXISTS user_email VARCHAR(100) AFTER user_id,
ADD COLUMN IF NOT EXISTS delivery_method VARCHAR(20) DEFAULT 'home' AFTER address,
ADD COLUMN IF NOT EXISTS payment_method VARCHAR(20) AFTER delivery_method,
ADD COLUMN IF NOT EXISTS note TEXT NULL AFTER transaction_info,
ADD COLUMN IF NOT EXISTS received_amount DECIMAL(15,2) DEFAULT 0.00 AFTER created_at,
ADD COLUMN IF NOT EXISTS lack_amount DECIMAL(15,2) DEFAULT 0 AFTER received_amount;

-- Fix order_details table - remove size column if exists, add product_name and image
ALTER TABLE order_details 
ADD COLUMN IF NOT EXISTS total DECIMAL(15,2) AFTER price,
ADD COLUMN IF NOT EXISTS product_name VARCHAR(255) NULL AFTER total,
ADD COLUMN IF NOT EXISTS image VARCHAR(255) NULL AFTER product_name;

-- If size column exists and you want to remove it (optional)
-- ALTER TABLE order_details DROP COLUMN IF EXISTS size;

-- Update lack_amount for existing orders
UPDATE orders 
SET lack_amount = total_amount - COALESCE(received_amount, 0)
WHERE lack_amount IS NULL OR lack_amount = 0;
