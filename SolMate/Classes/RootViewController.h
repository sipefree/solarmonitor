//
//  RootViewController.h
//  SolMate
//
//  Created by Simon Free on 28/05/2010.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <QuartzCore/QuartzCore.h>
#import "JSONDataSource.h"

@interface RootViewController : UIViewController {
	IBOutlet UITableView *tableView;
	IBOutlet UIButton *mainImage;
}
@property (nonatomic, retain) IBOutlet UITableView *tableView;
@property (nonatomic, retain) IBOutlet UIButton *mainImage;
@end
