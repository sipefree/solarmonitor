//
//  SMFlipsideViewController.h
//  UtilityTest
//
//  Created by Simon Free on 08/06/2010.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol SMFlipsideViewControllerDelegate;


@interface SMFlipsideViewController : UIViewController {
	id <SMFlipsideViewControllerDelegate> delegate;
}

@property (nonatomic, assign) id <SMFlipsideViewControllerDelegate> delegate;
- (IBAction)done;

@end


@protocol SMFlipsideViewControllerDelegate
- (void)flipsideViewControllerDidFinish:(SMFlipsideViewController *)controller;
@end

