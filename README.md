# COMaster1

## Info

**Content management system for journal publishing**

The platform is an end-to-end software system that assists at every stage of the peer-reviewed publication process. It allows organizing and monitoring the editorial workflow of an academic journal from paper submission to publication and is intended for members of the editorial board. 

The platform includes various tools, such as a submission wizard, an expert database, a review monitor, email notifications, an official document generator and many others, aimed at automating routine tasks, increasing the efficiency of editorial processes and reducing the cost of journal publishing.

The service was deployed on the infrastructure of Image Processing Systems Institute of the Russian Academy of Sciences, implemented into the management process of Computer Optics journal and supported from 2016 to 2018.

## Table of Contents
- [Features](#features)
  - [Common](#common)
  - [Functionality](#functionality)
- [Installation](#installation)
  - [For development](#for-development)
  - [For production](#for-production)
  - [For backup](#for-backup)
- [License](#license)

## Features

### Common
- Client-Server: PHP v7.4 + WordPress v5.8.3 + Bootstrap v3.3.7
- DB: MySQL v8
- Dockerized

### Functionality
- Submission wizard with automatic parsing of paper metadata
- Organizing peer-review process
- Email notifications of all changes to authors and the section editor
- Automatic generation of review forms (in English and Russian)
- Tracking the current status of papers
- Submission statistics
- Highlighting papers that require special attention (e.g. delays, pending acceptance/rejection, etc.)
- Formation of journal issues
- Expert database
- Statistics of experts and personal rate
- Payment management for reviewers
- Supportive information for editorial board meetings
- News section with a list of notable changes in the platform
- CRUD for Papers, Experts, Reviews, Issues and Sections
- Quick search
- Role-base access:
  - Chief editor: general information
  - Secretary: all functionality
  - Section editor: section-specific information, scientific acceptance
  - Technical editor: issue formation, technical acceptance
  - Layout designer: technical comments

## Installation

### For development

1. Create `.env`

2. Create `wp-config.php`

3. Fill in the salt in `wp-config.php`
```sh
curl https://api.wordpress.org/secret-key/1.1/salt/
```

4. Deploy
```sh
./deploy.sh
```

5. Create admin user
```sh
docker exec -it dev_com1_server php init.php
```

### For production

1. Create `.env`

2. Create `wp-config.php`

3. Fill in the salt in `wp-config.php`
```sh
curl https://api.wordpress.org/secret-key/1.1/salt/
```

4. Deploy
```sh
./deploy.sh --prod
```

5. Create admin user
```sh
docker exec -it prod_com1_server php init.php
```

### For backup

1. Install pv
```sh
sudo apt update && sudo apt install pv
```

## License

MIT License