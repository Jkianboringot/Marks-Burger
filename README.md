# 🍔 Marks Burger POS & Inventory System

## About the Project
Marks Burger is a rapidly growing burger chain in Catanduanes.  
With new branches opening frequently, the business faced challenges keeping up with orders, managing ingredient stock, and ensuring each branch had what it needed to serve customers efficiently.  

This project is a **web-based system** designed to make operations smoother, prevent ingredient shortages, and help managers track inventory across all branches.

---

## 🔹 The Problem
Before this system:  
- 📝 Orders were written down manually, slowing service and causing mistakes.  
- ⚠️ Popular branches often ran out of ingredients, frustrating customers and losing sales.  
- 📉 Managers had no easy way to monitor stock across multiple locations.

---

## 🔹 How the System Helps
- **💻 Simplified Order Management:** Orders are recorded digitally, making transactions faster and more accurate.  
- **📦 Inventory Monitoring:** Track ingredients in real-time at every branch.  
- **🚨 Smart Stock Alerts:** Managers get notified when supplies are running low and can quickly transfer ingredients between branches.  
- **📊 Branch Overview Dashboard:** See all branches’ stock levels at a glance, enabling faster decisions.

---

## 🔹 Architecture Diagram

```mermaid
flowchart LR

A[Branch Staff<br/>Cashier • Crew]
B[Branch Managers]
C[Business Owner]

A --> D[Web Browser POS]
B --> D
C --> D

D --> E[Frontend<br/>HTML • CSS • JS]
E --> F[Laravel Backend API]

F --> G[(Central Database<br/>MySQL/MariaDB)]

F --> H[Inventory Module]
F --> I[Order/Transaction Module]
F --> J[Notifications & Alerts]
F --> K[Branch Dashboard]
