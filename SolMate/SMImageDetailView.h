//
//  SMImageDetailView.h
//
//  Created by Simon Free on 14/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Foundation/Foundation.h>

@interface SMImageDetailView : /* Specify a superclass (eg: NSObject or NSView) */ {
    IBOutlet UIImageView *imageView;
}
- (IBAction)back:(UIButton *)sender;
- (IBAction)save:(UIButton *)sender;
@end
